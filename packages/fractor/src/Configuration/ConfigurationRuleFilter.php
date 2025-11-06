<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

/**
 * Modify available rector rules based on the configuration options
 */
final class ConfigurationRuleFilter
{
    private ?Configuration $configuration = null;

    public function setConfiguration(Configuration $configuration): void
    {
        $this->configuration = $configuration;
    }

    /**
     * @param iterable<FractorRule> $fractorRules
     * @return list<FractorRule>
     */
    public function filter(iterable $fractorRules): array
    {
        /** @var RewindableGenerator<FractorRule> $fractorRules */
        /** @var list<FractorRule> $fractors */
        $fractors = iterator_to_array($fractorRules->getIterator());

        if (! $this->configuration instanceof Configuration) {
            return $fractors;
        }

        $onlyRule = $this->configuration->getOnlyRule();
        if ($onlyRule !== null) {
            return $this->filterOnlyRule($fractors, $onlyRule);
        }

        return $fractors;
    }

    /**
     * @param list<FractorRule> $rectors
     * @return list<FractorRule>
     */
    public function filterOnlyRule(array $rectors, string $onlyRule): array
    {
        $activeRectors = [];
        foreach ($rectors as $rector) {
            if ($rector instanceof $onlyRule) {
                $activeRectors[] = $rector;
            }
        }

        return $activeRectors;
    }
}
