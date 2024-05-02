<?php

namespace a9f\FractorXml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\FractorXml\Contract\XmlFractor;
use a9f\FractorXml\ValueObjectFactory\DomDocumentFactory;
use DOMDocument;
use Webmozart\Assert\Assert;

final readonly class XmlFileProcessor implements FileProcessor
{
    /**
     * @param XmlFractor[] $rules
     */
    public function __construct(private iterable $rules, private DomDocumentFactory $domDocumentFactory)
    {
        Assert::allIsInstanceOf($this->rules, XmlFractor::class);
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'xml';
    }

    public function handle(File $file): void
    {
        $document = $this->domDocumentFactory->create();
        $document->load($file->getFilePath());

        // This is a hacky trick to keep format and create a nice diff later
        $file->changeOriginalContent($this->saveXml($document));

        foreach ($this->rules as $rule) {
            if (!$rule->canHandle($document)) {
                continue;
            }

            $rule->refactor($document);
        }

        $newFileContent = $this->saveXml($document);

        $file->changeFileContent($newFileContent);
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
