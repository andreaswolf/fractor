<?php

declare(strict_types=1);

namespace a9f\FractorXml\Tests\XmlFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;

final class XmlFileProcessorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.xml');
    }

    protected function additionalConfigurationFiles(): array
    {
        return [
            __DIR__ . '/config/config.php',
        ];
    }
}
