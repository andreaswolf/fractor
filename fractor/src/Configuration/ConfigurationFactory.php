<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Configuration\ValueObject\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Webmozart\Assert\Assert;

final readonly class ConfigurationFactory
{
    public function __construct(private ContainerBagInterface $parameterBag, private AllowedFileExtensionsResolver $allowedFileExtensionsResolver)
    {
    }

    public function createFromInput(InputInterface $input): Configuration
    {
        return new Configuration(
            $this->allowedFileExtensionsResolver->resolve(),
            (array)$this->parameterBag->get(Option::PATHS),
            (array)$this->parameterBag->get(Option::SKIP),
            (bool) $input->getOption(Option::DRY_RUN)
        );
    }

    /**
     * @api used in tests
     * @param string[] $paths
     */
    public function createForTests(array $paths): Configuration
    {
        Assert::allStringNotEmpty($paths, 'No directories given');

        return new Configuration(
            $this->allowedFileExtensionsResolver->resolve(),
            $paths,
            (array)$this->parameterBag->get(Option::SKIP),
            false
        );
    }
}
