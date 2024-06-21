<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Contract;

use a9f\Fractor\Application\Contract\FractorRule;
use Helmich\TypoScriptParser\Parser\AST\Statement;

interface TypoScriptFractor extends FractorRule, TypoScriptNodeVisitor
{
    public function refactor(Statement $statement): null|Statement|int;
}
