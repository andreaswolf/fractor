<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Contract;

use a9f\Fractor\Application\Contract\FractorRule;
use Helmich\TypoScriptParser\Parser\AST\Statement;

interface TypoScriptFractor extends FractorRule, TypoScriptNodeVisitor
{
    /**
     * @return null|Statement|int|list<Statement>
     */
    public function refactor(Statement $statement): null|Statement|int|array;
}
