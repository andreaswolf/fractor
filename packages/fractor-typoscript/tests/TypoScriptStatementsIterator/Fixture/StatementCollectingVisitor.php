<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Tests\TypoScriptStatementsIterator\Fixture;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptNodeVisitor;
use Helmich\TypoScriptParser\Parser\AST\Statement;

final class StatementCollectingVisitor implements TypoScriptNodeVisitor
{
    /**
     * @param list<non-empty-string> $calls
     */
    public function __construct(
        private readonly string $visitorName,
        public array &$calls // only public to please PHPStan
    ) {
    }

    /**
     * @param list<Statement> $statements
     */
    public function beforeTraversal(File $file, array $statements): void
    {
        $this->calls[] = sprintf('%s:beforeTraversal:%s', $this->visitorName, count($statements));
    }

    public function enterNode(Statement $node): Statement
    {
        $this->calls[] = sprintf('%s:enterNode:%s:l-%d', $this->visitorName, $node::class, $node->sourceLine);
        return $node;
    }

    public function leaveNode(Statement $node): void
    {
        $this->calls[] = sprintf('%s:leaveNode:%s:l-%d', $this->visitorName, $node::class, $node->sourceLine);
    }

    /**
     * @param list<Statement> $statements
     */
    public function afterTraversal(array $statements): void
    {
        $this->calls[] = sprintf('%s:afterTraversal:%s', $this->visitorName, count($statements));
    }
}
