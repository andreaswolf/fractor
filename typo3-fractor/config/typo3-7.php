<?php

use a9f\Typo3Fractor\TYPO37\FlexForm\AddRenderTypeToFlexFormFractor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();
    $services->set(AddRenderTypeToFlexFormFractor::class);
};
