<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\NodeTraverser;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\NodeVisitor\CallableStatementVisitor;
use a9f\FractorTypoScript\TypoScriptStatementsIterator;
use Helmich\TypoScriptParser\Parser\AST\Statement;

final class SimpleCallableStatementTraverser
{
    public function traverseNodesWithCallable(?Statement $statement, callable $callable): void
    {
        if ($statement === null) {
            return;
        }
        $callableStatementVisitor = new CallableStatementVisitor($callable);

        $nodeTraverser = new TypoScriptStatementsIterator([$callableStatementVisitor]);
        $nodeTraverser->traverseDocument(new File('', ''), [$statement]);
    }
}
