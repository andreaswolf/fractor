<?php

declare(strict_types=1);

use a9f\FractorComposerJson\ComposerJsonFileProcessor;
use a9f\FractorComposerJson\Contract\ComposerJsonFractorRule;
use a9f\FractorComposerJson\Contract\ComposerJsonPrinter;
use a9f\FractorComposerJson\ErgebnisComposerJsonPrinter;
use Ergebnis\Json\Printer\Printer;
use Ergebnis\Json\Printer\PrinterInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('a9f\\FractorComposerJson\\', __DIR__ . '/../src/');

    $services->set(ComposerJsonFileProcessor::class)
        ->arg('$rules', tagged_iterator('fractor.composer_json_rule'));

    $services->set(Printer::class);
    $services->alias(ComposerJsonPrinter::class, ErgebnisComposerJsonPrinter::class);
    $services->alias(PrinterInterface::class, Printer::class);
    $containerBuilder->registerForAutoconfiguration(ComposerJsonFractorRule::class)->addTag(
        'fractor.composer_json_rule'
    );
};
