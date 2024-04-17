<?php

use a9f\Fractor\Configuration\Option;
use a9f\Fractor\Contract\FileProcessor;
use a9f\Fractor\Factory\ConfigurationFactory;
use a9f\Fractor\Fractor\FractorRunner;
use a9f\Fractor\ValueObject\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBag;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, []);
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->public()
        ->autoconfigure();

    $services->load('a9f\\Fractor\\', __DIR__ . '/../src/')
        ->exclude(
            [
                __DIR__ . '/../src/Configuration',
                __DIR__ . '/../src/ValueObject',
                __DIR__ . '/../src/Testing',
            ]
        );

    $services->set('parameter_bag', ContainerBag::class)
        ->args([
            service('service_container'),
        ])
        ->alias(ContainerBagInterface::class, 'parameter_bag')
        ->alias(ParameterBagInterface::class, 'parameter_bag');

    $services->set(Configuration::class)->factory([service(ConfigurationFactory::class), 'create']);
    $services->set(FractorRunner::class)->arg('$processors', tagged_iterator('fractor.file_processor'));
    $services->set(ConfigurationFactory::class)->arg('$processors', tagged_iterator('fractor.file_processor'));

    $containerBuilder->registerForAutoconfiguration(FileProcessor::class)->addTag('fractor.file_processor');
};
