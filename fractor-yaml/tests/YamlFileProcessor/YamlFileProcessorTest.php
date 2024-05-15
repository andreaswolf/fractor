<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Tests\YamlFileProcessor;

use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
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

        $file = $this->fileCollector->getFileByPath($filePath);
        self::assertInstanceOf(File::class, $file);
        self::assertEquals([AppliedRule::fromClassString(DummyYamlFractorRule::class)], $file->getAppliedRules());
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.yaml');
    }

    protected function additionalConfigurationFiles(): array
    {
        return [__DIR__ . '/config/config.php'];
    }
}
