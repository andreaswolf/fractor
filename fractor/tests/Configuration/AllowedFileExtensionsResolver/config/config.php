<?php

declare(strict_types=1);

use a9f\Fractor\Rules\RulesProvider;
use a9f\Fractor\Tests\Fixture\DummyProcessor\Contract\TextRule;
use a9f\Fractor\Tests\Fixture\DummyProcessor\FileProcessor\TextFileProcessor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();
    $services->set('rules_providers.text_file')
        ->class(RulesProvider::class)
        ->arg('$baseClassOrInterface', TextRule::class)
        ->arg('$rules', tagged_iterator('fractor.text_rules'));
    $services->set(TextFileProcessor::class)
        ->arg('$rulesProvider', service('rules_providers.text_file'));
};
