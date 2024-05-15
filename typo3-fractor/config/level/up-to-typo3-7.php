<?php

declare(strict_types=1);

use a9f\Typo3Fractor\Set\Typo3SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(Typo3SetList::TYPO3_7);
};
