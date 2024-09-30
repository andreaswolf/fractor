<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v10\TypoScript;

use a9f\FractorTypoScript\AbstractTypoScriptFractor;
use a9f\FractorTypoScript\TypoScriptStatementsIterator;
use Helmich\TypoScriptParser\Parser\AST\Operator\Assignment;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/10.0/Deprecation-88406-SetCacheHashnoCacheHashOptionsInViewHelpersAndUriBuilder.html
 * @see \a9f\Typo3Fractor\Tests\TYPO3v10\TypoScript\RemoveUseCacheHashFromTypolinkTypoScriptFractor\RemoveUseCacheHashFromTypolinkTypoScriptFractorTest
 */
final class RemoveUseCacheHashFromTypolinkTypoScriptFractor extends AbstractTypoScriptFractor
{
    /**
     * @return null|Statement|int
     */
    public function refactor(Statement $statement)
    {
        if (! $statement instanceof Assignment) {
            return $statement;
        }

        // for some weird reason, "foo.bar.baz = 1" leads to "relativeName" being "foo.bar.baz"
        if (substr_compare(
            $statement->object->absoluteName,
            '.typolink.useCacheHash',
            -strlen('.typolink.useCacheHash')
        ) !== 0) {
            return $statement;
        }

        $this->hasChanged = true;
        return TypoScriptStatementsIterator::REMOVE_NODE;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Remove useCacheHash TypoScript setting', [new CodeSample(
            <<<'CODE_SAMPLE'
typolink {
    parameter = 3
    useCacheHash = 1
}
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
typolink {
    parameter = 3
}
CODE_SAMPLE
        )]);
    }
}
