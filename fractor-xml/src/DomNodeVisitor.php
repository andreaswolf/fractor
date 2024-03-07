<?php

namespace a9f\FractorXml;

/**
 * TODO decide if the methods should allow returning values that then replace things/modify the DOM?
 */
interface DomNodeVisitor
{
    public function beforeTraversal(\DOMNode $rootNode): void;

    public function enterNode(\DOMNode $node): void;

    public function leaveNode(\DOMNode $node): void;

    public function afterTraversal(\DOMNode $rootNode): void;
}