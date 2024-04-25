<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class SkipConfigurationFactory
{
    public function __construct(private ContainerBagInterface $parameterBag)
    {
    }

    public function create(): SkipConfiguration
    {
        return new SkipConfiguration(
            (array)$this->parameterBag->get(Option::SKIP),
        );
    }
}
