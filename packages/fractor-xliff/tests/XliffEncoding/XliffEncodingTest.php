<?php

declare(strict_types=1);

namespace a9f\FractorXliff\Tests\XliffEncoding;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Non-ASCII characters must stay literal and never be written as numeric entities.
 */
final class XliffEncodingTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.xlf.fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
