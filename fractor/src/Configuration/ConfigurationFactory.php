<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Configuration\ValueObject\Configuration;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class ConfigurationFactory
{
    public function __construct(private ContainerBagInterface $parameterBag, private AllowedFileExtensionsResolver $allowedFileExtensionsResolver)
    {
    }

    public function create(): Configuration
    {
        return new Configuration(
            $this->allowedFileExtensionsResolver->resolve(),
            $this->parameterBag->get(Option::PATHS),
        );
    }
}
