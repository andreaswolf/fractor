<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Tests\ReplacePackageAndVersionComposerJsonFractorRule;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorComposerJson\ReplacePackageAndVersionComposerJsonFractorRule;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class ReplacePackageAndVersionComposerJsonFractorRuleTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied($filePath, ReplacePackageAndVersionComposerJsonFractorRule::class);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.json');
    }

    public function provideConfigFilePath(): ?string
    {
        return __DIR__ . '/config/fractor.php';
    }

    protected function additionalConfigurationFiles(): array
    {
        return [__DIR__ . '/config/config.php'];
    }
}
