<?php

namespace a9f\Typo3Fractor;

use a9f\FractorXml\AbstractXmlFractor;

abstract class AbstractFlexformFractor extends AbstractXmlFractor
{
    public function canHandle(\DOMNode $node): bool
    {
        $rootNode = $node->ownerDocument?->firstChild;

        if ($rootNode === null) {
            // TODO convert into a custom ShouldNotHappenException
            throw new \RuntimeException('Node\'s document does not have a root node');
        }

        return $rootNode->nodeName === 'T3DataStructure';
    }
}
