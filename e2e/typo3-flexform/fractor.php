<?php

use a9f\Fractor\Configuration\Option;
use a9f\Typo3Fractor\Set\Typo3LevelSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__ . '/output/']);

    $containerConfigurator->import(Typo3LevelSetList::UP_TO_TYPO3_13);
};
