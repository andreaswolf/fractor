<?php

declare(strict_types=1);

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->private()
        ->autoconfigure();

    $services->load('a9f\\FractorRuleGenerator\\', __DIR__ . '/../../fractor-rule-generator/src')
        ->exclude([__DIR__ . '/../src/ValueObject', __DIR__ . '/../src/**/ValueObject']);

    $services->set(ConsoleOutput::class);
    $services->alias(OutputInterface::class, ConsoleOutput::class);
};
