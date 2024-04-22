<?php

namespace a9f\Typo3Fractor\TYPO3v7\FlexForm;

use a9f\Typo3Fractor\AbstractFlexformFractor;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/7.6/Deprecation-69822-DeprecateSelectFieldTca.html
 */
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
            $ownerDocument = $node->ownerDocument;

            if ($ownerDocument === null) {
                // TODO convert into a custom ShouldNotHappenException
                throw new \RuntimeException('Node does not have an ownerDocument');
            }

            $renderType = $ownerDocument->createElement('renderType');
            $renderType->nodeValue = 'selectSingle';
            $node->appendChild($renderType);
        }

        return $node;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Add renderType node in FlexForm', [
            new CodeSample(
                <<<'CODE_SAMPLE'
<T3DataStructure>
    <ROOT>
        <sheetTitle>aTitle</sheetTitle>
        <type>array</type>
        <el>
            <a_select_field>
                <label>Select field</label>
                <config>
                    <type>select</type>
                    <items>
                        <numIndex index="0" type="array">
                            <numIndex index="0">Label</numIndex>
                        </numIndex>
                    </items>
                </config>
            </a_select_field>
        </el>
    </ROOT>
</T3DataStructure>
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
<T3DataStructure>
    <ROOT>
        <sheetTitle>aTitle</sheetTitle>
        <type>array</type>
        <el>
            <a_select_field>
                <label>Select field</label>
                <config>
                    <type>select</type>
                    <renderType>selectSingle</renderType>
                    <items>
                        <numIndex index="0" type="array">
                            <numIndex index="0">Label</numIndex>
                        </numIndex>
                    </items>
                </config>
            </a_select_field>
        </el>
    </ROOT>
</T3DataStructure>
CODE_SAMPLE
            ),
        ]);
    }
}
