<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Console\Factory;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class SymfonyStyleFactory
{
    public static function create(): SymfonyStyle
    {
        $_SERVER['argv'] ??= [];
        $argvInput = new ArgvInput();
        $consoleOutput = new ConsoleOutput();
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (self::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(OutputInterface::VERBOSITY_QUIET);
        }

        return new SymfonyStyle($argvInput, $consoleOutput);
    }

    private static function isPHPUnitRun(): bool
    {
        return \defined('PHPUNIT_COMPOSER_INSTALL') || \defined('__PHPUNIT_PHAR__');
    }
}
