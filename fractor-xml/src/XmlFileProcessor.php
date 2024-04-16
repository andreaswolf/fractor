<?php

namespace a9f\FractorXml;

use a9f\Fractor\Contract\FileProcessor;
use a9f\Fractor\ValueObject\File;
use a9f\FractorXml\Contract\XmlFractor;

final class XmlFileProcessor implements FileProcessor
{
    /**
     * @param list<XmlFractor> $rules
     */
    public function __construct(private readonly iterable $rules)
    {
    }

    public function canHandle(\SplFileInfo $file): bool
    {
        return $file->getExtension() === 'xml';
    }

    public function handle(File $file): void
    {
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->load($file->getFilePath());

        // TODO we need a way to detect if there were changes (and probably also collect changes here)
        $iterator = new DomDocumentIterator($this->rules);
        $iterator->traverseDocument($doc);

        $newFileContent = $doc->saveXML();

        if ($newFileContent === false) {
            throw new \UnexpectedValueException('New file content should be a string');
        }

        $file->changeFileContent($newFileContent);
    }
}
