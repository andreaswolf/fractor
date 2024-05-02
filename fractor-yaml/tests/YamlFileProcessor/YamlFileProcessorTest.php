<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Tests\YamlFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class YamlFileProcessorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.yaml');
    }

    protected function additionalConfigurationFiles(): array
    {
        return [
            __DIR__ . '/config/config.php',
        ];
    }
}
