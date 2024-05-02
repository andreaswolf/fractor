<?php

use a9f\FractorYaml\Tests\Fixtures\DummyYamlFractorRule;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/../../../config/application.php');

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(DummyYamlFractorRule::class);
};
