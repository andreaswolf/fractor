<?php

declare(strict_types=1);

use a9f\FractorTypoScript\Contract\TypoScriptFractor;
use a9f\FractorTypoScript\TypoScriptFileProcessor;
use Helmich\TypoScriptParser\Parser\Parser;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinter;
use Helmich\TypoScriptParser\Tokenizer\Tokenizer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\FractorTypoScript\\', __DIR__ . '/../src/');

    $services->set(Tokenizer::class);
    $services->set(Parser::class)
        ->arg('$tokenizer', service(Tokenizer::class))
        ->public();
    $services->set(PrettyPrinter::class);

    $services->set(TypoScriptFileProcessor::class)
        ->arg('$rules', tagged_iterator('fractor.typoscript_rule'));

    $containerBuilder->registerForAutoconfiguration(TypoScriptFractor::class)
        ->addTag('fractor.typoscript_rule');
};
