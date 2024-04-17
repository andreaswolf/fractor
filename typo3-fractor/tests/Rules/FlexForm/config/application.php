<?php

use a9f\Fractor\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/../../../../config/application.php');
    $containerConfigurator->import(__DIR__ . '/../../../../../fractor-xml/config/application.php');

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__ . '/../Fixture/']);
};
