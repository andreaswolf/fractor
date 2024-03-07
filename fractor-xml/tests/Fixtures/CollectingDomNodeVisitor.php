<?php

namespace a9f\FractorXml\Tests\Fixtures;

use a9f\FractorXml\DomNodeVisitor;

class CollectingDomNodeVisitor implements DomNodeVisitor {
    /** @var list<non-empty-string> */
    public array $calls = [];

    public function beforeTraversal(\DOMNode $rootNode): void
    {
        $this->calls[] = sprintf('beforeTraversal:%s', $rootNode->nodeName);
    }

    public function enterNode(\DOMNode $node): \DOMNode|int
    {
        $this->calls[] = sprintf('enterNode:%s', $node->nodeName);
        return $node;
    }

    public function leaveNode(\DOMNode $node): void
    {
        $this->calls[] = sprintf('leaveNode:%s', $node->nodeName);
    }

    public function afterTraversal(\DOMNode $rootNode): void
    {
        $this->calls[] = sprintf('afterTraversal:%s', $rootNode->nodeName);
    }
}