<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v12\TypoScript;

use a9f\FractorTypoScript\AbstractTypoScriptFractor;
use a9f\FractorTypoScript\TypoScriptStatementsIterator;
use Helmich\TypoScriptParser\Parser\AST\Operator\Assignment;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Breaking-97701-RemovedTsConfigOptionDisableNewContentElementWizard.html
 */
final class RemoveNewContentElementWizardOptionsFractor extends AbstractTypoScriptFractor
{
    /**
     * @return null|Statement|int
     */
    public function refactor(Statement $statement)
    {
        if (! $statement instanceof Assignment) {
            return null;
        }

        if ($statement->object->absoluteName !== 'mod.web_layout.disableNewContentElementWizard'
            && $statement->object->absoluteName !== 'mod.newContentElementWizard.override') {
            return null;
        }

        return TypoScriptStatementsIterator::REMOVE_NODE;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Remove TSConfig mod.web_layout.disableNewContentElementWizard and mod.newContentElementWizard.override',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
mod.web_layout.disableNewContentElementWizard = 1
mod.newContentElementWizard.override = 1
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
-
CODE_SAMPLE
                ),

            ]
        );
    }
}
