<?php

declare(strict_types=1);

namespace a9f\Fractor\Factory;

use a9f\Fractor\Configuration\Option;
use a9f\Fractor\ValueObject\Configuration;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class ConfigurationFactory
{
    public function __construct(private ContainerBagInterface $parameterBag)
    {
    }

    public function create(): Configuration
    {
        return new Configuration(
            $this->parameterBag->get(Option::FILE_EXTENSIONS),
            $this->parameterBag->get(Option::PATHS),
        );
    }
}
