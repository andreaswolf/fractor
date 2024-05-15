<?php

declare(strict_types=1);

use a9f\FractorYaml\Contract\YamlDumper;
use a9f\FractorYaml\Contract\YamlFractorRule;
use a9f\FractorYaml\Contract\YamlParser;
use a9f\FractorYaml\SymfonyYamlDumper;
use a9f\FractorYaml\SymfonyYamlParser;
use a9f\FractorYaml\YamlFileProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\FractorYaml\\', __DIR__ . '/../src/');

    $services->alias(YamlParser::class, SymfonyYamlParser::class);
    $services->alias(YamlDumper::class, SymfonyYamlDumper::class);

    $services->set(YamlFileProcessor::class)->arg('$rules', tagged_iterator('fractor.yaml_rule'));

    $containerBuilder->registerForAutoconfiguration(YamlFractorRule::class)->addTag('fractor.yaml_rule');
};
