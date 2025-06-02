<?php

declare(strict_types=1);

use a9f\Typo3Fractor\TYPO3v14\Fluid\ChangeLogoutHandlingInFeLoginFractor;
use a9f\Typo3Fractor\TYPO3v14\TypoScript\RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor;
use a9f\Typo3Fractor\TYPO3v14\TypoScript\RemoveModWebLayoutDefLangBindingFractor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();

    $services->set(RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor::class);
    $services->set(RemoveModWebLayoutDefLangBindingFractor::class);
    $services->set(ChangeLogoutHandlingInFeLoginFractor::class);
};
