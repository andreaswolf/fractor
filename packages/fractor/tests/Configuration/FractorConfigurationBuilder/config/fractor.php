<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfigurationBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

return static function (ContainerBuilder $containerBuilder): void {
    /** @var FractorConfigurationBuilder $fractorConfiguration */
    $fractorConfiguration = $containerBuilder->get(FractorConfigurationBuilder::class);

    $fractorConfiguration->import(__DIR__ . '/imported_file.php');
};
