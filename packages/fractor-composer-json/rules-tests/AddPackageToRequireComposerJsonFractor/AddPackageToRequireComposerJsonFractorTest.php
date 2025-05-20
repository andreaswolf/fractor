<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\Tests\AddPackageToRequireComposerJsonFractor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorComposerJson\AddPackageToRequireComposerJsonFractor;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class AddPackageToRequireComposerJsonFractorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(AddPackageToRequireComposerJsonFractor::class);
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
