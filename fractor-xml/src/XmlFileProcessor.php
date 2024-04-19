<?php

namespace a9f\FractorXml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorXml\Contract\XmlFractor;
use Webmozart\Assert\Assert;

final readonly class XmlFileProcessor implements FileProcessor
{
    /**
     * @param XmlFractor[] $rules
     */
    public function __construct(private iterable $rules)
    {
        Assert::allIsInstanceOf($this->rules, XmlFractor::class);
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'xml';
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

    public function allowedFileExtensions(): array
    {
        return ['xml'];
    }
}
