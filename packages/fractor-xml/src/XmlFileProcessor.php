<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\Rules\RulesProvider;
use a9f\FractorXml\Contract\XmlFractor;
use a9f\FractorXml\ValueObjectFactory\DomDocumentFactory;
use DOMDocument;

final readonly class XmlFileProcessor implements FileProcessor
{
    /**
     * @param RulesProvider<XmlFractor> $rulesProvider
     */
    public function __construct(
        private DomDocumentFactory $domDocumentFactory,
        private RulesProvider $rulesProvider
    ) {
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'xml';
    }

    public function handle(File $file): void
    {
        $document = $this->domDocumentFactory->create();
        $originalXml = $file->getOriginalContent();
        $document->loadXML($originalXml);

        // This is a hacky trick to keep format and create a nice diff later
        $file->changeOriginalContent($this->saveXml($document));

        $applicableRulesForFile = $this->rulesProvider->getApplicableRules($file);

        $iterator = new DomDocumentIterator($applicableRulesForFile);
        $iterator->traverseDocument($file, $document);

        $newXml = $this->saveXml($document);

        if ($newXml === $originalXml) {
            return;
        }

        $file->changeFileContent($newXml);
    }

    public function allowedFileExtensions(): array
    {
        return ['xml'];
    }

    private function saveXml(DOMDocument $document): string
    {
        $xml = $document->saveXML();
        if ($xml === false) {
            throw new ShouldNotHappenException('New file content should be a string');
        }

        return $xml;
    }
}
