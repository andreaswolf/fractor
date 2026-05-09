<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Tests\TYPO3v10\TypoScript\RemoveConfigSimulateStaticDocumentsFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\Typo3Fractor\TYPO3v10\TypoScript\RemoveConfigSimulateStaticDocumentsFractor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(RemoveConfigSimulateStaticDocumentsFractor::class)]
final class RemoveConfigSimulateStaticDocumentsFractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.typoscript.fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
