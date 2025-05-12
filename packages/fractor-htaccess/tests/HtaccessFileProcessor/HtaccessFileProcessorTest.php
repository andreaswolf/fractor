<?php

declare(strict_types=1);

namespace a9f\FractorHtaccess\Tests\HtaccessFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorHtaccess\Tests\Fixtures\RemoveSetEnvIfRule;
use PHPUnit\Framework\Attributes\DataProvider;

final class HtaccessFileProcessorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(RemoveSetEnvIfRule::class);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '.htaccess.fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
