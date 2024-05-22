<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\Contract;

use Symplify\RuleDocGenerator\Contract\ConfigurableRuleInterface;

interface ConfigurableFractorRule extends FractorRule, ConfigurableRuleInterface
{
    /**
     * @param array<int|string, mixed> $configuration
     */
    public function configure(array $configuration): void;
}
