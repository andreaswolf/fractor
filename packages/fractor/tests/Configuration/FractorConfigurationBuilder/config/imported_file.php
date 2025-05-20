<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfigurationBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerBuilder $containerBuilder): void {
    /** @var FractorConfigurationBuilder $fractorConfiguration */
    $fractorConfiguration = $containerBuilder->get(FractorConfigurationBuilder::class);

    $fractorConfiguration->withPaths([dirname(__DIR__, 2)]);
};
