<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\Tests\TYPO3v8\TypoScript\RemoveConfigRenderCharsetFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\Typo3Fractor\TYPO3v8\TypoScript\RemoveConfigRenderCharsetFractor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(RemoveConfigRenderCharsetFractor::class)]
final class RemoveConfigRenderCharsetFractorTest extends AbstractFractorTestCase
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
