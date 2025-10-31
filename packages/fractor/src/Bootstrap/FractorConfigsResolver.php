<?php

declare(strict_types=1);

namespace a9f\Fractor\Bootstrap;

use a9f\Fractor\ValueObject\Bootstrap\BootstrapConfigs;
use Symfony\Component\Console\Input\ArgvInput;
use Webmozart\Assert\Assert;

final class FractorConfigsResolver
{
    public function provide(): BootstrapConfigs
    {
        $argvInput = new ArgvInput();
        $mainConfigFile = $this->resolveFromInputWithFallback($argvInput, 'fractor.php');

        return new BootstrapConfigs($mainConfigFile);
    }

    private function resolveFromInputWithFallback(ArgvInput $argvInput, string $fallbackFile): ?string
    {
        $configFile = $this->resolveFromInput($argvInput);
        return $configFile ?? $this->createFallbackFileInfoIfFound($fallbackFile);
    }

    private function resolveFromInput(ArgvInput $argvInput): ?string
    {
        $configFile = $this->getOptionValue($argvInput, ['--config', '-c']);
        if ($configFile === null) {
            return null;
        }

        Assert::fileExists($configFile);

        return (string) realpath($configFile);
    }

    private function createFallbackFileInfoIfFound(string $fallbackFile): ?string
    {
        $rootFallbackFile = getcwd() . DIRECTORY_SEPARATOR . $fallbackFile;
        if (! is_file($rootFallbackFile)) {
            return null;
        }

        return $rootFallbackFile;
    }

    /**
     * @param string[] $optionNames
     */
    private function getOptionValue(ArgvInput $argvInput, array $optionNames): ?string
    {
        foreach ($optionNames as $optionName) {
            if ($argvInput->hasParameterOption($optionName, true)) {
                return $argvInput->getParameterOption($optionName, null, true);
            }
        }

        return null;
    }
}
