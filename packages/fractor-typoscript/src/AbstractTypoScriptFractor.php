<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript;

use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorTypoScript\Contract\TypoScriptFractor;
use Helmich\TypoScriptParser\Parser\AST\Statement;

abstract class AbstractTypoScriptFractor implements TypoScriptFractor
{
    protected File $file;

    /**
     * @param list<Statement> $statements
     */
    final public function beforeTraversal(File $file, array $statements): void
    {
        $this->file = $file;
    }

    final public function enterNode(Statement $node): Statement|int
    {
        $result = $this->refactor($node);

        // no change => return unchanged node
        if ($result === null) {
            return $node;
        }

        $this->file->addAppliedRule(AppliedRule::fromRule($this));

        return $result;
    }

    final public function leaveNode(Statement $node): void
    {
    }

    /**
     * @param list<Statement> $statements
     */
    final public function afterTraversal(array $statements): void
    {
    }
}
