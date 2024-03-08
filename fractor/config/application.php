<?php

use a9f\Fractor\Configuration\FractorConfig;
use a9f\Fractor\FileSystem\FileFinder;
use a9f\Fractor\Fractor\FractorRunner;
use a9f\Fractor\FractorApplication;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\Fractor\\', __DIR__ . '/../src/')
        ->exclude('../src/Configuration/');

    $services->set(FractorApplication::class)
        ->public();

    $services->set(FileFinder::class);
    $services->set(FractorRunner::class);

    $services->set(FractorConfig::class)
        ->lazy(true);
};
