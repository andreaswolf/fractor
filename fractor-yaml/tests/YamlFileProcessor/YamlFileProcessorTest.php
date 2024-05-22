<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Tests\YamlFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorYaml\Tests\Fixtures\DummyYamlFractorRule;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class YamlFileProcessorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied($filePath, DummyYamlFractorRule::class);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.yaml');
    }

    public function provideConfigFilePath(): ?string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
