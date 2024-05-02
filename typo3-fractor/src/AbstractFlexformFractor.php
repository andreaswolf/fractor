<?php

namespace a9f\Typo3Fractor;

use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\FractorXml\Contract\XmlFractor;

abstract class AbstractFlexformFractor implements XmlFractor
{
    public function canHandle(\DOMNode $node): bool
    {
        $rootNode = $node->ownerDocument?->firstChild;

        if ($rootNode === null) {
            throw new ShouldNotHappenException('Node\'s document does not have a root node');
        }

        return $rootNode->nodeName === 'T3DataStructure';
    }
}
