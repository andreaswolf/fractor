<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Configuration\ValueObject\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Webmozart\Assert\Assert;

final readonly class ConfigurationFactory
{
    public function __construct(
        private ContainerBagInterface $parameterBag,
        private AllowedFileExtensionsResolver $allowedFileExtensionsResolver,
        private OnlyRuleResolver $onlyRuleResolver
    ) {
    }

    public function createFromInput(InputInterface $input): Configuration
    {
        /** @var list<non-empty-string> $paths */
        $paths = (array) $this->parameterBag->get(Option::PATHS);

        // filter rule and path
        $onlyRule = $input->getOption(Option::ONLY);
        if ($onlyRule !== null) {
            $onlyRule = $this->onlyRuleResolver->resolve($onlyRule);
        }

        return new Configuration(
            $this->allowedFileExtensionsResolver->resolve(),
            $paths,
            (array) $this->parameterBag->get(Option::SKIP),
            (bool) $input->getOption(Option::DRY_RUN),
            (bool) $input->getOption(Option::QUIET),
            $onlyRule
        );
    }

    /**
     * @api used in tests
     * @param list<non-empty-string> $paths
     */
    public function createForTests(array $paths): Configuration
    {
        Assert::allStringNotEmpty($paths, 'No directories given');

        return new Configuration(
            $this->allowedFileExtensionsResolver->resolve(),
            $paths,
            (array) $this->parameterBag->get(Option::SKIP),
            false,
            false
        );
    }
}
