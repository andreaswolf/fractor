<?php

declare(strict_types=1);

namespace a9f\FractorXliff\Tests\EnsureXliffHasSourceLanguageFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorXliff\EnsureXliffHasSourceLanguageFractor;
use PHPUnit\Framework\Attributes\DataProvider;

final class EnsureXliffHasSourceLanguageFractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(EnsureXliffHasSourceLanguageFractor::class);
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
