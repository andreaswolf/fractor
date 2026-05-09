<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Tests\TYPO3v10\TypoScript\RemoveConfigLanguageAltFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\Typo3Fractor\TYPO3v10\TypoScript\RemoveConfigLanguageAltFractor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(RemoveConfigLanguageAltFractor::class)]
final class RemoveConfigLanguageAltFractorTest extends AbstractFractorTestCase
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
