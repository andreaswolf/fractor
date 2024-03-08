<?php

namespace a9f\FractorXml;

/**
 * TODO decide if the methods should allow returning values that then replace things/modify the DOM?
 */
interface DomNodeVisitor
{
    public function beforeTraversal(\DOMNode $rootNode): void;

    /**
     * @return \DOMNode|DomDocumentIterator::*
     */
    public function enterNode(\DOMNode $node): \DOMNode|int;

    public function leaveNode(\DOMNode $node): void;

    public function afterTraversal(\DOMNode $rootNode): void;
}
