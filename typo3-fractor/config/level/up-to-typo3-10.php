<?php

use a9f\Typo3Fractor\Set\Typo3LevelSetList;
use a9f\Typo3Fractor\Set\Typo3SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(Typo3LevelSetList::UP_TO_TYPO3_9);
    $containerConfigurator->import(Typo3SetList::TYPO3_10);
};
