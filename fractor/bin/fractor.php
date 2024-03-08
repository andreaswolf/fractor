<?php

use a9f\Fractor\Configuration\ConfigResolver;
use a9f\Fractor\DependencyInjection\ContainerBuilder;
use a9f\Fractor\FractorApplication;
use Symfony\Component\Console\Input\ArgvInput;

include __DIR__ . '/../vendor/autoload.php';

$configFile = ConfigResolver::resolveConfigsFromInput(new ArgvInput());

$container = (new ContainerBuilder())->createDependencyInjectionContainer($configFile);

/** @var FractorApplication $application */
$application = $container->get(FractorApplication::class);
$application->run();
