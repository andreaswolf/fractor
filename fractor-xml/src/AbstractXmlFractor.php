<?php

namespace a9f\FractorXml;

abstract class AbstractXmlFractor implements DomNodeVisitor, XmlFractor
{
    public function beforeTraversal(\DOMNode $rootNode): void
    {
        // no-op for now
    }

    public function enterNode(\DOMNode $node): \DOMNode|int
    {
        if (!$this->canHandle($node)) {
            return $node;
        }

        return $this->refactor($node) ?? $node;
    }

    public function leaveNode(\DOMNode $node): void
    {
        // no-op for now
    }

    public function afterTraversal(\DOMNode $rootNode): void
    {
        // no-op for now
    }
}