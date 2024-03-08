<?php

namespace a9f\FractorXml;

use a9f\Fractor\Fractor\FileProcessor;

final class XmlFileProcessor implements FileProcessor
{
    /**
     * @param list<XmlFractor> $rules
     */
    public function __construct(private readonly array $rules)
    {
    }

    public function canHandle(\SplFileInfo $file): bool
    {
        return $file->getExtension() === 'xml';
    }

    public function handle(\SplFileInfo $file): void
    {
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->load($file->getPathname());

        // TODO we need a way to detect if there were changes (and probably also collect changes here)
        $iterator = new DomDocumentIterator($this->rules);
        $iterator->traverseDocument($doc);

        // TODO only update file if changed
        file_put_contents($file->getPathname(), $doc->saveXML());
    }
}