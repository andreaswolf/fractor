<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Tests\ReplacePackageAndVersionComposerJsonFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorComposerJson\ReplacePackageAndVersionComposerJsonFractor;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class ReplacePackageAndVersionComposerJsonFractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(ReplacePackageAndVersionComposerJsonFractor::class);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.json.fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
