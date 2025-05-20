<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v12\TypoScript;

use a9f\FractorTypoScript\AbstractTypoScriptFractor;
use Helmich\TypoScriptParser\Parser\AST\NestedAssignment;
use Helmich\TypoScriptParser\Parser\AST\Operator\Assignment;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Important-97159-MailLinkHandlerKeyInTSconfigRenamed.html
 */
final class RenameTcemainLinkHandlerMailKeyFractor extends AbstractTypoScriptFractor
{
    public function refactor(Statement $statement): null|Statement|int
    {
        if (! $statement instanceof NestedAssignment && ! $statement instanceof Assignment) {
            return null;
        }

        if ($statement->object->absoluteName !== 'TCEMAIN.linkHandler.mail') {
            return null;
        }

        $statement->object->relativeName = 'email';
        $statement->object->absoluteName = 'TCEMAIN.linkHandler.email';

        return $statement;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Rename key mail to email for MailLinkHandler', [new CodeSample(
            <<<'CODE_SAMPLE'
TCEMAIN.linkHandler {
    mail {
        handler = TYPO3\CMS\Recordlist\LinkHandler\MailLinkHandler
        label = LLL:EXT:recordlist/Resources/Private/Language/locallang_browse_links.xlf:email
        displayAfter = page,file,folder,url
        scanBefore = url
    }
}
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
TCEMAIN.linkHandler {
    email {
        handler = TYPO3\CMS\Recordlist\LinkHandler\MailLinkHandler
        label = LLL:EXT:recordlist/Resources/Private/Language/locallang_browse_links.xlf:email
        displayAfter = page,file,folder,url
        scanBefore = url
    }
}
CODE_SAMPLE
        )]);
    }
}
