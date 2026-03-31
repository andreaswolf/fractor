<?php

declare(strict_types=1);

namespace a9f\FractorXliff\ConvertXliff1To2Fractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorXliff\ConvertXliff1To2Fractor;
use PHPUnit\Framework\Attributes\DataProvider;

final class ConvertXliff1To2FractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(ConvertXliff1To2Fractor::class);
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
