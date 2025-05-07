<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();
    //$services->set(\a9f\Typo3Fractor\TYPO3v13\Fluid\MigrateBooleanAndNullAttributeValuesToNativeTypesFractor::class); Do not use rule as it doesn't respect aria attributes which still have to be "true"
};
