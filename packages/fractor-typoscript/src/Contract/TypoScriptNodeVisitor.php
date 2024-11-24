<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Contract;

use a9f\Fractor\Application\ValueObject\File;
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

    public function enterNode(Statement $node): Statement|int|null;

    public function leaveNode(Statement $node): Statement|int|null;

    /**
     * @param list<Statement> $statements
     */
    public function afterTraversal(array $statements): void;
}
