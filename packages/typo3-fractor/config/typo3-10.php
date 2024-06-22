<?php

declare(strict_types=1);

use a9f\Typo3Fractor\TYPO3v10\Fluid\RemoveNoCacheHashAndUseCacheHashAttributeFluidFractor;
use a9f\Typo3Fractor\TYPO3v10\TypoScript\RemoveUseCacheHashFromTypolinkTypoScriptFractor;
use a9f\Typo3Fractor\TYPO3v10\Yaml\EmailFinisherYamlFractor;
use a9f\Typo3Fractor\TYPO3v10\Yaml\TranslationFileYamlFractor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();

    $services->set(EmailFinisherYamlFractor::class);
    $services->set(TranslationFileYamlFractor::class);
    $services->set(RemoveNoCacheHashAndUseCacheHashAttributeFluidFractor::class);
    $services->set(RemoveUseCacheHashFromTypolinkTypoScriptFractor::class);
};
