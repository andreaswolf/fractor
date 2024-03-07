<?php

use a9f\Fractor\FractorApplication;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/../utils/generator/config/config.php', null, true);

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\Fractor\\', __DIR__ . '/../src/');

    $services->set(FractorApplication::class)
        ->public();
};