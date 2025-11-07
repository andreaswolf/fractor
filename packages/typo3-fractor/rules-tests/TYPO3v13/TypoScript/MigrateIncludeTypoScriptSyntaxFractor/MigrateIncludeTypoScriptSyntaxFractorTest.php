<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Tests\TYPO3v13\TypoScript\MigrateIncludeTypoScriptSyntaxFractor;

use a9f\Fractor\Contract\FilesystemInterface;
use a9f\Fractor\Contract\LocalFilesystemInterface;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class MigrateIncludeTypoScriptSyntaxFractorTest extends AbstractFractorTestCase
{
    private FilesystemInterface $filesystem;

    private LocalFilesystemInterface $localFilesystem;

    /**
     * @var string[]
     */
    private array $testFilesToDelete = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->initializeFilesystems();
    }

    protected function tearDown(): void
    {
        foreach ($this->testFilesToDelete as $filename) {
            $this->localFilesystem->delete($filename);
        }

        parent::tearDown();
    }

    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.typoscript.fixture');
    }

    /**
     * @dataProvider provideExtensionData
     */
    public function testWithExistingExtEmConf(string $extensionKey, ?string $newFile, ?string $fileToRewrite): void
    {
        // Arrange
        $extEmConf = __DIR__ . '/Extensions/' . $extensionKey . '/ext_emconf.php';
        $this->testFilesToDelete[] = $extEmConf;
        $this->localFilesystem->write($extEmConf, '');

        if ($fileToRewrite !== null) {
            $absoluteFileToRewrite = __DIR__ . '/Extensions/' . $extensionKey . '/' . $fileToRewrite;
            $this->testFilesToDelete[] = $absoluteFileToRewrite;
            $this->filesystem->write($absoluteFileToRewrite, '');
            $this->localFilesystem->write($absoluteFileToRewrite, '');
        }

        // Act
        $this->doTestFile(
            __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/setup.typoscript.fixture'
        );
        $this->testFilesToDelete[] = __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.typoscript';

        // Assert
        if ($newFile !== null) {
            self::assertTrue(
                $this->filesystem->fileExists(__DIR__ . '/Extensions/' . $extensionKey . '/' . $newFile)
            );
        }
        if ($fileToRewrite !== null) {
            self::assertFalse(
                $this->filesystem->fileExists(__DIR__ . '/Extensions/' . $extensionKey . '/' . $fileToRewrite)
            );
        }
    }

    /**
     * @dataProvider provideExtensionData
     */
    public function testWithExistingComposerJson(string $extensionKey, ?string $newFile, ?string $fileToRewrite): void
    {
        // Arrange
        $composerJson = __DIR__ . '/Extensions/' . $extensionKey . '/composer.json';
        $this->testFilesToDelete[] = $composerJson;
        $this->localFilesystem->write($composerJson, '{
    "extra": {
        "typo3/cms": {
            "extension-key": "' . $extensionKey . '"
        }
    }
}
');

        if ($fileToRewrite !== null) {
            $absoluteFileToRewrite = __DIR__ . '/Extensions/' . $extensionKey . '/' . $fileToRewrite;
            $this->testFilesToDelete[] = $absoluteFileToRewrite;
            $this->filesystem->write($absoluteFileToRewrite, '');
            $this->localFilesystem->write($absoluteFileToRewrite, '');
        }

        // Act
        $this->doTestFile(
            __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/setup.typoscript.fixture'
        );
        $this->testFilesToDelete[] = __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.typoscript';

        // Assert
        if ($newFile !== null) {
            self::assertTrue(
                $this->filesystem->fileExists(__DIR__ . '/Extensions/' . $extensionKey . '/' . $newFile)
            );
        }
        if ($fileToRewrite !== null) {
            self::assertFalse(
                $this->filesystem->fileExists(__DIR__ . '/Extensions/' . $extensionKey . '/' . $fileToRewrite)
            );
        }
    }

    /**
     * @return \Iterator<array<int, string|null>>
     */
    public static function provideExtensionData(): \Iterator
    {
        yield 'Test that *.ts files are renamed to *.typoscript with ts include only' => [
            'extension1',
            'Configuration/TypoScript/Includes/file.typoscript',
            'Configuration/TypoScript/Includes/file.ts',
        ];
        yield 'Test that *.ts files are renamed to *.typoscript with mixed include' => [
            'extension2',
            'Configuration/TypoScript/Includes/file.typoscript',
            'Configuration/TypoScript/Includes/file.ts',
        ];
        yield 'Test that *.tsconfig.typoscript files are imported with tsconfig.typoscript extension' => [
            'extension3',
            null,
            null,
        ];
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }

    private function initializeFilesystems(): void
    {
        $this->filesystem = $this->getService(FilesystemInterface::class);
        $this->localFilesystem = $this->getService(LocalFilesystemInterface::class);
    }
}
