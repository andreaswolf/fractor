<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript;

use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptFractor;
use a9f\FractorTypoScript\NodeTraverser\SimpleCallableStatementTraverser;
use Helmich\TypoScriptParser\Parser\AST\Statement;

abstract class AbstractTypoScriptFractor implements TypoScriptFractor
{
    protected File $file;

    protected bool $hasChanged = false;

    public function __construct(
        private readonly SimpleCallableStatementTraverser $simpleCallableStatementTraverser
    ) {
    }

    /**
     * @param list<Statement> $statements
     */
    final public function beforeTraversal(File $file, array $statements): void
    {
        $this->file = $file;
    }

    final public function enterNode(Statement $node): Statement|int|null
    {
        $result = $this->refactor($node);

        // no change => return unchanged node
        if ($result === null) {
            return $node;
        }

        $this->file->addAppliedRule(AppliedRule::fromRule($this));

        return $result;
    }

    final public function leaveNode(Statement $node): int|Statement|null
    {
        return null;
    }

    /**
     * @param list<Statement> $statements
     */
    final public function afterTraversal(array $statements): void
    {
    }

    protected function traverseStatementsWithCallable(?Statement $statement, callable $callable): void
    {
        $this->simpleCallableStatementTraverser->traverseNodesWithCallable($statement, $callable);
    }
}
