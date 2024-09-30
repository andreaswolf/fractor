<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Contract\Formatter;
use a9f\FractorXml\Contract\XmlFractor;
use a9f\FractorXml\ValueObjectFactory\DomDocumentFactory;

/**
 * @implements FileProcessor<XmlFractor>
 */
final class XmlFileProcessor implements FileProcessor
{
    /**
     * @readonly
     */
    private DomDocumentFactory $domDocumentFactory;

    /**
     * @readonly
     */
    private Formatter $formatter;

    /**
     * @var iterable<XmlFractor>
     * @readonly
     */
    private iterable $rules;

    /**
     * @readonly
     */
    private Indent $indent;

    /**
     * @param iterable<XmlFractor> $rules
     */
    public function __construct(DomDocumentFactory $domDocumentFactory, Formatter $formatter, iterable $rules, Indent $indent)
    {
        $this->domDocumentFactory = $domDocumentFactory;
        $this->formatter = $formatter;
        $this->rules = $rules;
        $this->indent = $indent;
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'xml';
    }

    public function handle(File $file, iterable $appliedRules): void
    {
        $document = $this->domDocumentFactory->create();
        $originalXml = $file->getOriginalContent();
        $document->loadXML($originalXml);

        // This is a hacky trick to keep format and create a nice diff later
        $oldXml = $this->saveXml($document);
        $oldXml = $this->formatter->format($this->indent, $oldXml) . "\n";
        $file->changeOriginalContent($oldXml);

        $iterator = new DomDocumentIterator($appliedRules);
        $iterator->traverseDocument($file, $document);

        $newXml = $this->saveXml($document);
        $newXml = $this->formatter->format($this->indent, $newXml) . "\n";

        if ($newXml === $originalXml) {
            return;
        }

        $file->changeFileContent($newXml);
    }

    public function allowedFileExtensions(): array
    {
        return ['xml'];
    }

    public function getAllRules(): iterable
    {
        return $this->rules;
    }

    private function saveXml(\DOMDocument $document): string
    {
        $xml = $document->saveXML();
        if ($xml === false) {
            throw new ShouldNotHappenException('New file content should be a string');
        }

        return $xml;
    }
}
