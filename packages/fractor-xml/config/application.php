<?php

declare(strict_types=1);

use a9f\Fractor\Rules\RulesProvider;
use a9f\FractorXml\Contract\XmlFractor;
use a9f\FractorXml\XmlFileProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\FractorXml\\', __DIR__ . '/../src/');

    $services->set('rules_providers.xml_rule')
        ->class(RulesProvider::class)
        ->arg('$baseClassOrInterface', XmlFractor::class)
        ->arg('$rules', tagged_iterator('fractor.xml_rule'));
    $services->set(XmlFileProcessor::class)
        ->arg('$rulesProvider', service('rules_providers.xml_rule'));

    $containerBuilder->registerForAutoconfiguration(XmlFractor::class)->addTag('fractor.xml_rule');
};
