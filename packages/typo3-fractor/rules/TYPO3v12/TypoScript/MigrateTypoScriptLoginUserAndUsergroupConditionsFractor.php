<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v12\TypoScript;

use a9f\FractorTypoScript\AbstractTypoScriptFractor;
use Helmich\TypoScriptParser\Parser\AST\ConditionalStatement;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.4/Deprecation-100349-TypoScriptLoginUserAndUsergroupConditions.html
 * @see \a9f\Typo3Fractor\Tests\TYPO3v12\TypoScript\MigrateTypoScriptLoginUserAndUsergroupConditionsFractor\MigrateTypoScriptLoginUserAndUsergroupConditionsFractorTest
 */
final class MigrateTypoScriptLoginUserAndUsergroupConditionsFractor extends AbstractTypoScriptFractor
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Migrate TypoScript loginUser() and usergroup() conditions', [new CodeSample(
            <<<'CODE_SAMPLE'
[loginUser('*')]
    page = PAGE
    page.20 = TEXT
    page.20.value = User is logged in
[end]
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
[frontend.user.isLoggedIn]
    page = PAGE
    page.20 = TEXT
    page.20.value = User is logged in
[end]
CODE_SAMPLE
        ), new CodeSample(
            <<<'CODE_SAMPLE'
[usergroup(11)]
    page = PAGE
    page.70 = TEXT
    page.70.value = Frontend user is member of group with uid 11
[end]
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
[11 in frontend.user.userGroupIds]
    page = PAGE
    page.70 = TEXT
    page.70.value = Frontend user is member of group with uid 11
[end]
CODE_SAMPLE
        )]);
    }

    public function refactor(Statement $statement): ?Statement
    {
        if (! $statement instanceof ConditionalStatement) {
            return null;
        }

        $condition = $statement->condition;
        $originalCondition = $condition;

        // handle wildcard negations for both functions
        $condition = (string) preg_replace(
            '/(loginUser|usergroup)\([\'"]\*[\'"]\)\s*===\s*false/',
            '!frontend.user.isLoggedIn',
            $condition
        );

        // handle wildcards for both functions
        $condition = (string) preg_replace(
            '/(loginUser|usergroup)\([\'"]\*[\'"]\)/',
            'frontend.user.isLoggedIn',
            $condition
        );

        // handle loginUser with specific IDs
        $condition = (string) preg_replace_callback(
            '/loginUser\(([\'"]?)([\d,\s]+)\1\)/',
            static function (array $matches): string {
                $values = array_map(trim(...), explode(',', $matches[2]));
                if (count($values) > 1) {
                    return 'frontend.user.userId in [' . implode(',', $values) . ']';
                }
                return 'frontend.user.userId == ' . $values[0];
            },
            $condition
        );

        // handle usergroup migration with || operator for multiple IDs
        $condition = (string) preg_replace_callback(
            '/usergroup\(([\'"]?)([\d,\s]+)\1\)/',
            static function (array $matches): string {
                $values = array_map(trim(...), explode(',', $matches[2]));

                $mappedConditions = array_map(
                    static fn (string $id): string => sprintf('%s in frontend.user.userGroupIds', $id),
                    $values
                );

                return implode(' || ', $mappedConditions);
            },
            $condition
        );

        if ($condition === $originalCondition) {
            return null;
        }

        $statement->condition = $condition;

        return $statement;
    }
}
