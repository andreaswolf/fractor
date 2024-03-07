<?php

namespace a9f\Typo3Fractor\Tests\Rules\FlexForm;

use a9f\FractorXml\DomDocumentIterator;
use a9f\Typo3Fractor\Rules\FlexForm\AddRenderTypeToFlexFormFractor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AddRenderTypeToFlexFormFractorTest extends TestCase
{
    /**
     * @return array<string, string>
     */
    public static function fixtureFilesProvider(): array
    {
        return [
            'select without renderType' => [__DIR__ . '/Fixtures/SelectWithoutRenderType.xml.inc'],
        ];
    }

    #[DataProvider('fixtureFilesProvider')]
    public function test(string $filePath): void
    {
        $fixture = file_get_contents($filePath);
        [$originalXml, $expectedResultXml] = array_map('trim',
            explode('-----', $fixture)
        );

        $document = new \DOMDocument();
        $document->loadXML($originalXml);

        $iterator = new DomDocumentIterator([new AddRenderTypeToFlexFormFractor()]);
        $iterator->traverseDocument($document);

        $result = $document->saveXML();

        self::assertXmlStringEqualsXmlString($expectedResultXml, $result);
    }
}