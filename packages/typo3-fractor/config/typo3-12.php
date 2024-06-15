<?php

declare(strict_types=1);

use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEmailFlagToEmailTypeFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateInternalTypeFolderToTypeFolderFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateNullFlagFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateRenderTypeColorpickerToTypeColorFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\Fluid\AbstractMessageGetSeverityFluidRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();

    $services->set(AbstractMessageGetSeverityFluidRector::class);
    $services->set(MigrateEmailFlagToEmailTypeFlexFormFractor::class);
    $services->set(MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor::class);
    $services->set(MigrateInternalTypeFolderToTypeFolderFlexFormFractor::class);
    $services->set(MigrateNullFlagFlexFormFractor::class);
    $services->set(MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor::class);
    $services->set(MigrateRenderTypeColorpickerToTypeColorFlexFormFractor::class);
};
