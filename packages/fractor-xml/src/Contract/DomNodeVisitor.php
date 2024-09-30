<?php

declare(strict_types=1);

namespace a9f\FractorXml\Contract;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorXml\DomDocumentIterator;

/**
 * TODO decide if the methods should allow returning values that then replace things/modify the DOM?
 */
interface DomNodeVisitor
{
    public function beforeTraversal(File $file, \DOMDocument $rootNode): void;

    /**
     * @return \DOMNode|DomDocumentIterator::*
     */
    public function enterNode(\DOMNode $node);

    public function leaveNode(\DOMNode $node): void;

    public function afterTraversal(\DOMDocument $rootNode): void;
}
