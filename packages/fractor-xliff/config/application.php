<?php

declare(strict_types=1);

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXliff\Contract\XliffFractorRule;
use a9f\FractorXliff\IndentFactory;
use a9f\FractorXliff\ValueObject\XliffFormatConfiguration;
use a9f\FractorXliff\XliffFileProcessor;
use PrettyXml\Formatter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\FractorXliff\\', __DIR__ . '/../src/');

    $services->set('fractor.xliff_processor.indent', Indent::class)
        ->factory([service(IndentFactory::class), 'create']);

    $services->set('fractor.xliff_processor.format_configuration', XliffFormatConfiguration::class)
        ->factory([null, 'createFromParameterBag']);

    $services->set(XliffFileProcessor::class)
        ->arg('$indent', service('fractor.xliff_processor.indent'))
        ->arg('$rules', tagged_iterator('fractor.xliff_rule'))
        ->arg('$xliffFormatConfiguration', service('fractor.xliff_processor.format_configuration'));

    $services->set(Formatter::class);

    $containerBuilder->registerForAutoconfiguration(XliffFractorRule::class)->addTag('fractor.xliff_rule');
};
