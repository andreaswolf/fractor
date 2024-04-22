<?php

use a9f\Fractor\Configuration\Option;
use a9f\Typo3Fractor\Set\Typo3SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/application.php');
    $containerConfigurator->import(__DIR__ . '/../../../../../../../fractor-xml/config/application.php');
    $containerConfigurator->import(Typo3SetList::TYPO3_7);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__ . '/../Fixtures/']);
};
