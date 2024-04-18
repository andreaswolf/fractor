<?php

declare(strict_types=1);

namespace a9f\Fractor\Factory;

use a9f\Fractor\Configuration\Option;
use a9f\Fractor\Contract\FileProcessor;
use a9f\Fractor\ValueObject\Configuration;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class ConfigurationFactory
{
    /**
     * @param list<FileProcessor> $processors
     */
    public function __construct(private ContainerBagInterface $parameterBag, private iterable $processors)
    {
    }

    public function create(): Configuration
    {
        $fileExtensions = [];
        foreach ($this->processors as $processor) {
            $fileExtensions = array_merge($processor->allowedFileExtensions(), $fileExtensions);
        }

        return new Configuration(
            array_unique($fileExtensions),
            $this->parameterBag->get(Option::PATHS),
        );
    }
}
