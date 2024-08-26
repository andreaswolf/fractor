<?php

declare(strict_types=1);

namespace a9f\Fractor\Console\Output;

use a9f\Fractor\ChangesReporting\Contract\Output\OutputFormatterInterface;
use a9f\Fractor\Exception\Configuration\InvalidConfigurationException;

final class OutputFormatterCollector
{
    /**
     * @var array<string, OutputFormatterInterface>
     */
    private array $outputFormatters = [];

    /**
     * @param OutputFormatterInterface[] $outputFormatters
     */
    public function __construct(iterable $outputFormatters)
    {
        foreach ($outputFormatters as $outputFormatter) {
            $this->outputFormatters[$outputFormatter->getName()] = $outputFormatter;
        }
    }

    public function getByName(string $name): OutputFormatterInterface
    {
        $this->ensureOutputFormatExists($name);
        return $this->outputFormatters[$name];
    }

    private function ensureOutputFormatExists(string $name): void
    {
        if (isset($this->outputFormatters[$name])) {
            return;
        }
        $outputFormatterNames = \array_keys($this->outputFormatters);
        throw new InvalidConfigurationException(\sprintf(
            'Output formatter "%s" was not found. Pick one of "%s".',
            $name,
            \implode('", "', $outputFormatterNames)
        ));
    }
}
