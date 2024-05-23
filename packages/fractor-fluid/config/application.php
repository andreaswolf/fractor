<?php

declare(strict_types=1);

use a9f\FractorFluid\Contract\FluidFractorRule;
use a9f\FractorFluid\FluidFileProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\FractorFluid\\', __DIR__ . '/../src/');

    $services->set(FluidFileProcessor::class)
        ->arg('$rules', tagged_iterator('fractor.fluid_rule'));

    $containerBuilder->registerForAutoconfiguration(FluidFractorRule::class)->addTag('fractor.fluid_rule');
};
