<?php

namespace a9f\Typo3Fractor\Rules\FlexForm;

use a9f\FractorXml\AbstractXmlFractor;
use a9f\Typo3Fractor\AbstractFlexformFractor;

final class AddRenderTypeToFlexFormFractor extends AbstractFlexformFractor
{
    public function canHandle(\DOMNode $node): bool
    {
        return parent::canHandle($node) && $node->nodeName === 'config';
    }

    public function refactor(\DOMNode $node): \DOMNode|int|null
    {
        $isSelectElement = false;
        /** @var \DOMNode $childNode */
        foreach ($node->childNodes->getIterator() as $childNode) {
            if ($childNode->nodeName === 'type' && $childNode->nodeValue === 'select') {
                $isSelectElement = true;
                break;
            }
        }

        if (!$isSelectElement) {
            return $node;
        }

        $isSingleSelect = false;
        /** @var \DOMNode $childNode */
        foreach ($node->childNodes->getIterator() as $childNode) {
            if ($childNode->nodeName === 'maxitems' && (int)$childNode->nodeValue === 1) {
                $isSingleSelect = true;
                $node->removeChild($childNode);
                break;
            }
        }

        if ($isSingleSelect) {
            $renderType = $childNode->ownerDocument->createElement('renderType');
            $renderType->nodeValue = 'selectSingle';
            $node->appendChild($renderType);
        }

        return $node;
    }
}