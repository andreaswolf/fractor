<?php

declare(strict_types=1);

namespace a9f\FractorXliff\Tests\EnsureXliffHasTargetLanguageFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorXliff\EnsureXliffHasTargetLanguageFractor;
use PHPUnit\Framework\Attributes\DataProvider;

final class EnsureXliffHasTargetLanguageFractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(EnsureXliffHasTargetLanguageFractor::class);
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
