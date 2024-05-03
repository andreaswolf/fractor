<?php

use a9f\Fractor\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SKIP, [
        // windows slashes
        __DIR__ . '\non-existing-path',
        __DIR__ . '/../Fixtures',
        '*\Mask\*',
    ]);
};
