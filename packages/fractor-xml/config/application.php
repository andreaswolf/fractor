<?php

declare(strict_types=1);

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Contract\Formatter;
use a9f\FractorXml\Contract\XmlFractor;
use a9f\FractorXml\IndentFactory;
use a9f\FractorXml\PrettyXmlFormatter;
use a9f\FractorXml\ValueObject\XmlFormatConfiguration;
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

    $services->set('fractor.xml_processor.indent', Indent::class)
        ->factory([service(IndentFactory::class), 'create']);

    $services->set('fractor.xml_processor.format_configuration', XmlFormatConfiguration::class)
        ->factory([null, 'createFromParameterBag']);

    $services->set(XmlFileProcessor::class)
        ->arg('$indent', service('fractor.xml_processor.indent'))
        ->arg('$rules', tagged_iterator('fractor.xml_rule'))
        ->arg('$xmlFormatConfiguration', service('fractor.xml_processor.format_configuration'));

    $services->set(\PrettyXml\Formatter::class);
    $services->alias(Formatter::class, PrettyXmlFormatter::class);

    $containerBuilder->registerForAutoconfiguration(XmlFractor::class)->addTag('fractor.xml_rule');
};
