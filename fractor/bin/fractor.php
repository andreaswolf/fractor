<?php

use a9f\Fractor\DependencyInjection\ContainerBuilder;
use a9f\Fractor\FractorApplication;

include __DIR__ . '/../vendor/autoload.php';

$container = (new ContainerBuilder())->createDependencyInjectionContainer();

/** @var FractorApplication $application */
$application = $container->get(FractorApplication::class);
$application->run();
