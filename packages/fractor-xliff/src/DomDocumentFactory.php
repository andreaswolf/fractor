<?php

declare(strict_types=1);

namespace a9f\FractorXliff;

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
