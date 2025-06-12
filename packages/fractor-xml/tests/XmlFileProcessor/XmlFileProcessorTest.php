<?php

declare(strict_types=1);

namespace a9f\FractorXml\Tests\XmlFileProcessor;

use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use a9f\FractorXml\Tests\Fixtures\DummyXmlFractorRule;
use PHPUnit\Framework\Attributes\DataProvider;

final class XmlFileProcessorTest extends AbstractFractorTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
        $this->assertThatRuleIsApplied(DummyXmlFractorRule::class);
    }

    public static function provideData(): \Iterator
    {
        return self::yieldFilesFromDirectory(__DIR__ . '/Fixtures', '*.xml.fixture');
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }
}
