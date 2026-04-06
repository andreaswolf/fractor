<?php

declare(strict_types=1);

namespace a9f\FractorXliff\Tests\XliffFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorXliff\Tests\Fixtures\DummyXliffFractorRule;
use PHPUnit\Framework\Attributes\DataProvider;

final class XliffFileProcessorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(DummyXliffFractorRule::class);
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
