<?php

declare(strict_types=1);

use a9f\Fractor\Tests\Fixture\DummyProcessor\FileProcessor\TextFileProcessor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();
    $services->set(TextFileProcessor::class)->arg('$rules', tagged_iterator('fractor.text_rules'));
};
