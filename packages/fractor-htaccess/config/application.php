<?php

declare(strict_types=1);

use a9f\FractorHtaccess\Contract\HtaccessFractorRule;
use a9f\FractorHtaccess\HtaccessFileProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Tivie\HtaccessParser\Parser;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\FractorHtaccess\\', __DIR__ . '/../src/');

    $services->set(Parser::class)
        ->public();

    $services->set(HtaccessFileProcessor::class)
        ->arg('$rules', tagged_iterator('fractor.htaccess_rule'));

    $containerBuilder->registerForAutoconfiguration(HtaccessFractorRule::class)
        ->addTag('fractor.htaccess_rule');
};
