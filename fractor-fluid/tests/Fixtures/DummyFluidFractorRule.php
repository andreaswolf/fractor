<?php

declare(strict_types=1);

namespace a9f\FractorFluid\Tests\Fixtures;

use a9f\FractorFluid\Contract\FluidFractorRule;
use Nette\Utils\Strings;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class DummyFluidFractorRule implements FluidFractorRule
{
    public function getRuleDefinition(): RuleDefinition
    {
        throw new BadMethodCallException('Not implemented yet');
    }

    public function refactor(string $fluid): string
    {
        $fluid = Strings::replace($fluid, '# noCacheHash="(1|0|true|false)"#imsU', '');

        return Strings::replace($fluid, '# useCacheHash="(1|0|true|false)"#imsU', '');
    }
}
