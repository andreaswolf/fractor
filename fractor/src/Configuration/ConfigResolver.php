<?php

namespace a9f\Fractor\Configuration;

use Symfony\Component\Console\Input\ArgvInput;

final class ConfigResolver
{
    public static function resolveConfigsFromInput(ArgvInput $input): ?string
    {
        $configurationFile = self::getConfigFileFromInput($input) ?? getcwd() . '/fractor.php';

        return $configurationFile;
    }

    private static function getConfigFileFromInput(ArgvInput $input): ?string
    {
        // TODO validate if the file exists
        return self::getOptionValue($input, ['--config', '-c']);
    }

    /**
     * @param list<string> $nameCandidates
     */
    private static function getOptionValue(ArgvInput $input, array $nameCandidates): ?string
    {
        foreach ($nameCandidates as $name) {
            if ($input->hasParameterOption($name, true)) {
                return $input->getParameterOption($name, null, true);
            }
        }

        return null;
    }
}
