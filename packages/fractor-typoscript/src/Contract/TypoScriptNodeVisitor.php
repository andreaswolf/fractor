<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Contract;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\TypoScriptStatementsIterator;
use Helmich\TypoScriptParser\Parser\AST\Statement;

/**
 * Interface for node visitors. Will be called for each node in the tree.
 */
interface TypoScriptNodeVisitor
{
    /**
     * @param list<Statement> $statements
     */
    public function beforeTraversal(File $file, array $statements): void;

    /**
     * @return Statement|list<Statement>|TypoScriptStatementsIterator::*
     */
    public function enterNode(Statement $node): Statement|array|int;

    public function leaveNode(Statement $node): void;

    /**
     * @param list<Statement> $statements
     */
    public function afterTraversal(array $statements): void;
}
