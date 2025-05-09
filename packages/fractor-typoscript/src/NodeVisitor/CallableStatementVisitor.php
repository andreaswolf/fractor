<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\NodeVisitor;

use a9f\FractorTypoScript\TypoScriptStatementsIterator;
use Helmich\TypoScriptParser\Parser\AST\Statement;

final class CallableStatementVisitor extends StatementVisitorAbstract
{
    /**
     * @var callable(Statement): (Statement|int|null)
     */
    private $callable;

    private ?int $statementIdToRemove = null;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function enterNode(Statement $node): int|null|Statement
    {
        $originalStatement = $node;
        $callable = $this->callable;
        /** @var int|Statement|null $newStatement */
        $newStatement = $callable($node);
        if ($newStatement === TypoScriptStatementsIterator::REMOVE_NODE) {
            $this->statementIdToRemove = \spl_object_id($originalStatement);
            return $originalStatement;
        }
        return $newStatement;
    }

    public function leaveNode(Statement $node): int|Statement
    {
        if ($this->statementIdToRemove !== null && $this->statementIdToRemove === \spl_object_id($node)) {
            $this->statementIdToRemove = null;
            return TypoScriptStatementsIterator::REMOVE_NODE;
        }
        return $node;
    }
}
