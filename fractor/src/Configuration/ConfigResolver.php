<?php

namespace a9f\Fractor\Configuration;

use Symfony\Component\Console\Input\ArgvInput;

final class ConfigResolver
{
    public static function resolveConfigsFromInput(ArgvInput $input): ?string
    {
        return self::getOptionValue($input) ?? getcwd() . '/fractor.php';
    }

    /**
     */
    private static function getOptionValue(ArgvInput $input): ?string
    {
        $nameCandidates = ['--config', '-c'];
        foreach ($nameCandidates as $name) {
            if ($input->hasParameterOption($name, true)) {
                return $input->getParameterOption($name, null, true);
            }
        }

        return null;
    }
}
