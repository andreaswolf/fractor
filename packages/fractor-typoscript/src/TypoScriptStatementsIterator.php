<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptNodeVisitor;
use Helmich\TypoScriptParser\Parser\AST\ConditionalStatement;
use Helmich\TypoScriptParser\Parser\AST\NestedAssignment;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Webmozart\Assert\Assert;

final class TypoScriptStatementsIterator
{
    /**
     * @var int
     */
    public const REMOVE_NODE = 3;

    /**
     * @var array<TypoScriptNodeVisitor>
     * @readonly
     */
    private iterable $visitors;

    /**
     * @param list<TypoScriptNodeVisitor> $visitors
     */
    public function __construct(
        iterable $visitors
    ) {
        $visitors = iterator_to_array($visitors);
        Assert::allIsInstanceOf($visitors, TypoScriptNodeVisitor::class);
        $this->visitors = $visitors;
    }

    /**
     * @param list<Statement> $statements
     * @return list<Statement>
     */
    public function traverseDocument(File $file, array $statements): array
    {
        foreach ($this->visitors as $visitor) {
            $visitor->beforeTraversal($file, $statements);
        }

        $resultingStatements = $this->processStatementList($statements);

        foreach ($this->visitors as $visitor) {
            $visitor->afterTraversal($statements);
        }

        return $resultingStatements;
    }

    /**
     * @param list<Statement> $statements
     * @return list<Statement>
     */
    private function processStatementList(array $statements): array
    {
        $resultingStatements = [];
        foreach ($statements as $statement) {
            $result = $this->traverseNode($statement);

            if (is_array($result)) {
                $resultingStatements[] = $result;
            } elseif ($result instanceof Statement) {
                $resultingStatements[] = [$result];
            }
        }
        return array_merge(...$resultingStatements);
    }

    /**
     * @return self::*|Statement|list<Statement>
     */
    private function traverseNode(Statement $node)
    {
        $lastCalledVisitor = null;
        $result = $node;
        foreach ($this->visitors as $visitor) {
            $result = $visitor->enterNode($node);

            if (is_int($result)) {
                $lastCalledVisitor = $visitor;
                break;
            }
        }

        if ($node instanceof ConditionalStatement) {
            $node->ifStatements = $this->processStatementList($node->ifStatements);
            $node->elseStatements = $this->processStatementList($node->elseStatements);
        } elseif ($node instanceof NestedAssignment) {
            $node->statements = $this->processStatementList($node->statements);
        }

        foreach ($this->visitors as $visitor) {
            if ($lastCalledVisitor === $visitor) {
                break;
            }
            $visitor->leaveNode($node);
        }
        return $result;
    }
}
