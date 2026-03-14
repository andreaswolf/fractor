<?php

declare(strict_types=1);

use a9f\Typo3Fractor\TYPO3v8\TypoScript\RemoveConfigPrefixLocalAnchorsFractor;
use a9f\Typo3Fractor\TYPO3v8\TypoScript\RemoveConfigRenderCharsetFractor;
use a9f\Typo3Fractor\TYPO3v8\TypoScript\RemoveModNewPageWizOverrideWithExtensionFractor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();

    $services->set(RemoveConfigPrefixLocalAnchorsFractor::class);
    $services->set(RemoveConfigRenderCharsetFractor::class);
    $services->set(RemoveModNewPageWizOverrideWithExtensionFractor::class);
};
