<?php

namespace a9f\FractorXml\Contract;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\FractorXml\DomDocumentIterator;

interface XmlFractor extends FractorRule
{
    public function canHandle(\DOMNode $node): bool;

    /**
     * @return \DOMNode|DomDocumentIterator::*|null
     */
    public function refactor(\DOMNode $node): \DOMNode|int|null;
}
