<?php

namespace a9f\FractorXml;

final class DomDocumentIterator
{
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
        foreach ($this->visitors as $visitor) {
            $visitor->enterNode($node);
        }

        foreach ($node->childNodes->getIterator() as $childNode) {
            $this->traverseNode($childNode);
        }

        foreach ($this->visitors as $visitor) {
            $visitor->leaveNode($node);
        }
    }
}
