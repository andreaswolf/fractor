<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\RuleSkipper;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\FractorXml\Contract\XmlFractor;
use a9f\FractorXml\ValueObjectFactory\DomDocumentFactory;
use DOMDocument;
use Webmozart\Assert\Assert;
use function Safe\file_get_contents;

final readonly class XmlFileProcessor implements FileProcessor
{
    /**
     * @param XmlFractor[] $rules
     */
    public function __construct(
        private iterable $rules,
        private DomDocumentFactory $domDocumentFactory,
        private RuleSkipper $ruleSkipper
    ) {
        Assert::allIsInstanceOf($this->rules, XmlFractor::class);
    }

    public function canHandle(File $file): bool
    {
        return $file->getFileExtension() === 'xml';
    }

    public function handle(File $file): void
    {
        $document = $this->domDocumentFactory->create();
        $originalXml = file_get_contents($file->getFilePath());
        $document->loadXML($originalXml);

        // This is a hacky trick to keep format and create a nice diff later
        $file->changeOriginalContent($this->saveXml($document));

        $applicableRulesForFile = array_filter(
            // for a large number of rules, this might be resource hungry; try to find a better alternative here
            iterator_to_array($this->rules),
            fn (XmlFractor $rule) => $this->ruleSkipper->shouldSkip($rule::class, $file->getFilePath()) === false
        );

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
