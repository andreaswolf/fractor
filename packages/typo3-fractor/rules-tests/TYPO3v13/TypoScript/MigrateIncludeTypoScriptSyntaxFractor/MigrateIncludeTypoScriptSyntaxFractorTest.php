<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Tests\TYPO3v13\TypoScript\MigrateIncludeTypoScriptSyntaxFractor;

use a9f\Fractor\Contract\FilesystemInterface;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class MigrateIncludeTypoScriptSyntaxFractorTest extends AbstractFractorTestCase
{
    private FilesystemInterface $filesystem;

    /**
     * @var string[]
     */
    private array $testFilesToDelete = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->initializeFilesystem();
    }

    protected function tearDown(): void
    {
        foreach ($this->testFilesToDelete as $filename) {
            $this->filesystem->delete($filename);
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
    public function testWithExistingExtEmConf(string $extensionKey): void
    {
        // Arrange
        $extEmConf = __DIR__ . '/Extensions/' . $extensionKey . '/ext_emconf.php';
        $this->testFilesToDelete[] = $extEmConf;
        $this->filesystem->write($extEmConf, '');

        $tsFile = __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.ts';
        $this->testFilesToDelete[] = $tsFile;
        $this->filesystem->write($tsFile, '');

        // Act
        $this->doTestFile(
            __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/setup.typoscript.fixture'
        );
        $this->testFilesToDelete[] = __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.typoscript';

        // Assert
        self::assertTrue(
            $this->filesystem->fileExists(
                __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.typoscript'
            )
        );
        self::assertFalse(
            $this->filesystem->fileExists(
                __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.ts'
            )
        );
    }

    /**
     * @dataProvider provideExtensionData
     */
    public function testWithExistingComposerJson(string $extensionKey): void
    {
        // Arrange
        $composerJson = __DIR__ . '/Extensions/' . $extensionKey . '/composer.json';
        $this->testFilesToDelete[] = $composerJson;
        $this->filesystem->write($composerJson, '{
    "extra": {
        "typo3/cms": {
            "extension-key": "' . $extensionKey . '"
        }
    }
}
');

        $tsFile = __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.ts';
        $this->testFilesToDelete[] = $tsFile;
        $this->filesystem->write($tsFile, '');

        // Act
        $this->doTestFile(
            __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/setup.typoscript.fixture'
        );
        $this->testFilesToDelete[] = __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.typoscript';

        // Assert
        self::assertTrue(
            $this->filesystem->fileExists(
                __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.typoscript'
            )
        );
        self::assertFalse(
            $this->filesystem->fileExists(
                __DIR__ . '/Extensions/' . $extensionKey . '/Configuration/TypoScript/Includes/file.ts'
            )
        );
    }

    /**
     * @return \Iterator<array<string>>
     */
    public static function provideExtensionData(): \Iterator
    {
        yield 'Test that *.ts files are renamed to *.typoscript with ts include only' => ['extension1'];
        yield 'Test that *.ts files are renamed to *.typoscript with mixed include' => ['extension2'];
    }

    public function provideConfigFilePath(): ?string
    {
        return __DIR__ . '/config/fractor.php';
    }

    private function initializeFilesystem(): void
    {
        $this->filesystem = $this->getService(FilesystemInterface::class);
    }
}
