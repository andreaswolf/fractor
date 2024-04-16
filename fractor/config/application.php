<?php

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\Contract\FileProcessor;
use a9f\Fractor\Fractor\FractorRunner;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->public()
        ->autoconfigure();

    $services->load('a9f\\Fractor\\', __DIR__ . '/../src/')
        ->exclude(
            [
                __DIR__ . '/../src/Configuration',
                __DIR__ . '/../src/ValueObject',
            ]
        );


    $services->set(FractorRunner::class)->arg('$processors', tagged_iterator('fractor.file_processor'));
    $services->set(FractorConfig::class)
        ->lazy();

    $containerBuilder->registerForAutoconfiguration(FileProcessor::class)->addTag('fractor.file_processor');
};
