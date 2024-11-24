<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\NodeVisitor;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptNodeVisitor;
use Helmich\TypoScriptParser\Parser\AST\Statement;

abstract class StatementVisitorAbstract implements TypoScriptNodeVisitor
{
    public function beforeTraversal(File $file, array $statements): void
    {
    }

    public function enterNode(Statement $node): int|null|Statement
    {
        return null;
    }

    public function leaveNode(Statement $node): int|null|Statement
    {
        return null;
    }

    public function afterTraversal(array $statements): void
    {
    }
}
