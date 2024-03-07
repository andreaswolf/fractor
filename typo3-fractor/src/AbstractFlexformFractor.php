<?php

namespace a9f\Typo3Fractor;

use a9f\FractorXml\AbstractXmlFractor;
use a9f\FractorXml\XmlFractor;

abstract class AbstractFlexformFractor extends AbstractXmlFractor
{
    public function canHandle(\DOMNode $node): bool
    {
        return $node->ownerDocument->firstChild->nodeName === 'T3DataStructure';
    }
}