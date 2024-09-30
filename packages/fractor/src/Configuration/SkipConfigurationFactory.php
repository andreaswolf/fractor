<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final class SkipConfigurationFactory
{
    /**
     * @readonly
     */
    private ContainerBagInterface $parameterBag;

    public function __construct(ContainerBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function create(): SkipConfiguration
    {
        return new SkipConfiguration((array) $this->parameterBag->get(Option::SKIP));
    }
}
