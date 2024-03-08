<?php

namespace a9f\FractorXml;

interface XmlFractor extends DomNodeVisitor
{
    public function canHandle(\DOMNode $node): bool;

    /**
     * @return \DOMNode|DomDocumentIterator::*|null
     */
    public function refactor(\DOMNode $node): \DOMNode|int|null;
}
