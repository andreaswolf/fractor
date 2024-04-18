<?php

declare(strict_types=1);

namespace a9f\FractorXml\ValueObjectFactory;

final class DomDocumentFactory
{
    public function create(): \DOMDocument
    {
        $document = new \DOMDocument();
        $document->preserveWhiteSpace = false;
        $document->formatOutput = true;

        return $document;
    }
}
