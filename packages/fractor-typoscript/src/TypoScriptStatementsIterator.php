<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptNodeVisitor;
use Helmich\TypoScriptParser\Parser\AST\ConditionalStatement;
use Helmich\TypoScriptParser\Parser\AST\NestedAssignment;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Webmozart\Assert\Assert;

final readonly class TypoScriptStatementsIterator
{
    /**
     * @var int
     */
    public const REMOVE_NODE = 3;

    /**
     * @var TypoScriptNodeVisitor[]
     */
    private iterable $visitors;

    /**
     * @param TypoScriptNodeVisitor[] $visitors
     */
    public function __construct(iterable $visitors)
    {
        $visitors = iterator_to_array($visitors);
        Assert::allIsInstanceOf($visitors, TypoScriptNodeVisitor::class);
        $this->visitors = $visitors;
    }

    /**
     * @param Statement[] $statements
     * @return Statement[]
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
     * @param Statement[] $statements
     * @return Statement[]
     */
    private function processStatementList(array $statements): array
    {
        $resultingStatements = [];
        foreach ($statements as $statement) {
            $result = $this->traverseNode($statement);

            if ($result instanceof Statement) {
                $resultingStatements[] = [$result];
            } elseif (is_array($result)) {
                $resultingStatements[] = $result;
            }
        }
        return array_merge(...$resultingStatements);
    }

    /**
     * @return int|Statement|list<Statement>
     */
    private function traverseNode(Statement $node): int|Statement|array
    {
        $lastCalledVisitor = null;
        $command = null;

        foreach ($this->visitors as $visitor) {
            $return = $visitor->enterNode($node);

            if ($return instanceof Statement) {
                $node = $return;
                continue;
            }

            if (is_array($return)) {
                return $return;
            }

            if ($return === self::REMOVE_NODE) {
                $command = self::REMOVE_NODE;
                $lastCalledVisitor = $visitor;
                break;
            }
        }

        if ($command !== self::REMOVE_NODE) {
            if ($node instanceof ConditionalStatement) {
                $node->ifStatements = $this->processStatementList($node->ifStatements);
                $node->elseStatements = $this->processStatementList($node->elseStatements);
            } elseif ($node instanceof NestedAssignment) {
                $node->statements = $this->processStatementList($node->statements);
            }
        }

        foreach ($this->visitors as $visitor) {
            if ($lastCalledVisitor === $visitor) {
                break;
            }

            $return = $visitor->leaveNode($node);
            if ($return === null) {
                continue;
            }

            $node = $return;
        }

        if ($command === self::REMOVE_NODE) {
            return self::REMOVE_NODE;
        }

        return $node;
    }
}
