<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorXml\Contract\DomNodeVisitor;
use a9f\FractorXml\Exception\ShouldNotHappenException;
use Webmozart\Assert\Assert;

final readonly class DomDocumentIterator
{
    /**
     * @var int
     */
    public const REMOVE_NODE = 3;

    /**
     * @var array<DomNodeVisitor>
     */
    private iterable $visitors;

    /**
     * @param list<DomNodeVisitor> $visitors
     */
    public function __construct(iterable $visitors)
    {
        $visitors = iterator_to_array($visitors);
        Assert::allIsInstanceOf($visitors, DomNodeVisitor::class);
        $this->visitors = $visitors;
    }

    public function traverseDocument(File $file, \DOMDocument $document): void
    {
        foreach ($this->visitors as $visitor) {
            $visitor->beforeTraversal($file, $document);
        }

        if ($document->firstChild instanceof \DOMNode) {
            $this->traverseNode($document->firstChild);
        }

        foreach ($this->visitors as $visitor) {
            $visitor->afterTraversal($document);
        }
    }

    private function traverseNode(\DOMNode $node): void
    {
        $traverseChildren = true;
        foreach ($this->visitors as $visitor) {
            $result = $visitor->enterNode($node);

            /** @var \DOMElement $node */
            if ($result === self::REMOVE_NODE) {
                if ($node->parentNode === null) {
                    throw new ShouldNotHappenException(sprintf(
                        'Node with tagName "%s" has no parent node and cannot be removed.',
                        $node->tagName
                    ));
                }
                $node->parentNode->removeChild($node);
                $traverseChildren = false;
            } elseif ($result->isSameNode($node) === false) {
                if ($node->parentNode === null) {
                    throw new ShouldNotHappenException(sprintf(
                        'Node with tagName "%s" has no parent node and cannot be replaced.',
                        $node->tagName
                    ));
                }
                $node->parentNode->replaceChild($result, $node);
                $traverseChildren = false;
            }
        }

        if ($traverseChildren) {
            // the iterator is invalidated/modified if the nodes change during traversal => create a copy here to
            // prevent this
            $childNodes = iterator_to_array($node->childNodes->getIterator());
            foreach ($childNodes as $childNode) {
                $this->traverseNode($childNode);
            }
        }

        foreach ($this->visitors as $visitor) {
            $visitor->leaveNode($node);
        }
    }
}
