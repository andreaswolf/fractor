<?php

declare(strict_types=1);

use a9f\Typo3Fractor\TYPO3v7\TypoScript\RemoveOptionAlternateBgColorsFractor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();

    $services->set(RemoveOptionAlternateBgColorsFractor::class);
};
