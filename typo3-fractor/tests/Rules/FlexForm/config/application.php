<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\a9f\Fractor\Configuration\Option::FILE_EXTENSIONS, ['xml']);
    $parameters->set(\a9f\Fractor\Configuration\Option::PATHS, [__DIR__ . '/../Fixture/']);
};
