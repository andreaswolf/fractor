<?php

use a9f\Fractor\Configuration\Option;
use a9f\Fractor\Tests\Helper\Contract\TextRule;
use a9f\Fractor\Tests\Helper\FileProcessor\TextFileProcessor;
use a9f\Fractor\Tests\Helper\Rules\ReplaceXXXTextRule;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__ . '/../Fixtures/']);
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(ReplaceXXXTextRule::class);
    $services->set(TextFileProcessor::class)->arg('$rules', tagged_iterator('fractor.text_rules'));
    $containerBuilder->registerForAutoconfiguration(TextRule::class)->addTag('fractor.text_rules');
};
