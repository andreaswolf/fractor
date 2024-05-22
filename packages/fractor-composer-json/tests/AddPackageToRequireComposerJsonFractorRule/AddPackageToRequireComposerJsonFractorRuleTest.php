<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Tests\AddPackageToRequireComposerJsonFractorRule;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorComposerJson\AddPackageToRequireComposerJsonFractorRule;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class AddPackageToRequireComposerJsonFractorRuleTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied($filePath, AddPackageToRequireComposerJsonFractorRule::class);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.json');
    }

    public function provideConfigFilePath(): ?string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
