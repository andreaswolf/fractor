<?php

declare(strict_types=1);

use a9f\FractorFluid\Tests\Fixtures\DummyFluidFractorRule;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/../../../config/application.php');

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(DummyFluidFractorRule::class);
};
