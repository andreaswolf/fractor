<?php

namespace a9f\FractorXml;

final class DomDocumentIterator
{
    /** @var int */
    public const REMOVE_NODE = 3;

    /**
     * @param list<DomNodeVisitor> $visitors
     */
    public function __construct(private readonly array $visitors)
    {
    }

    public function traverseDocument(\DOMDocument $document): void
    {
        foreach ($this->visitors as $visitor) {
            $visitor->beforeTraversal($document);
        }

        $this->traverseNode($document->firstChild);

        foreach ($this->visitors as $visitor) {
            $visitor->afterTraversal($document);
        }
    }

    private function traverseNode(\DOMNode $node): void
    {
        $nodeRemoved = false;
        foreach ($this->visitors as $visitor) {
            $result = $visitor->enterNode($node);

            if ($result === DomDocumentIterator::REMOVE_NODE) {
                $node->parentNode->removeChild($node);
                $nodeRemoved = true;
            } elseif ($result->isSameNode($node) === false) {
                $node->parentNode->replaceChild($result, $node);
                $nodeRemoved = true; // "replaced", actually, but that's close enough for us
            }
        }

        if ($nodeRemoved === false) {
            foreach ($node->childNodes->getIterator() as $childNode) {
                $this->traverseNode($childNode);
            }
        }

        foreach ($this->visitors as $visitor) {
            $visitor->leaveNode($node);
        }
    }
}
