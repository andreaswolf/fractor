<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Tests\Fixtures;

use a9f\FractorTypoScript\AbstractTypoScriptFractor;
use a9f\FractorTypoScript\TypoScriptStatementsIterator;
use Helmich\TypoScriptParser\Parser\AST\Operator\Assignment;
use Helmich\TypoScriptParser\Parser\AST\Statement;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class DummyTypoScriptFractorRule extends AbstractTypoScriptFractor
{
    public function refactor(Statement $statement): null|Statement|int
    {
        if (! $statement instanceof Assignment) {
            return null;
        }

        if ($statement->object->absoluteName !== 'config.spamProtectEmailAddresses'
            || $statement->value->value !== 'ascii'
        ) {
            return null;
        }

        return TypoScriptStatementsIterator::REMOVE_NODE;
    }

    public function getRuleDefinition(): RuleDefinition
    {
        throw new BadMethodCallException('Not implemented yet');
    }
}
