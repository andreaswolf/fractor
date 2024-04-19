<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\Contract;

use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;

if (interface_exists(FractorRule::class)) {
    return;
}


interface FractorRule extends DocumentedRuleInterface
{
}
