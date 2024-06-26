<?php

declare(strict_types=1);

use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEmailFlagToEmailTypeFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateInternalTypeFolderToTypeFolderFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateNullFlagFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateRenderTypeColorpickerToTypeColorFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateRequiredFlagFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateTypeNoneColsToSizeFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\FlexForm\RemoveTceFormsDomElementFlexFormFractor;
use a9f\Typo3Fractor\TYPO3v12\Fluid\AbstractMessageGetSeverityFluidFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigDisablePageExternalUrlFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigDoctypeSwitchFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigMetaCharsetFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigSendCacheHeadersOnlyWhenLoginDeniedInBranchFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveConfigSpamProtectEmailAddressesAsciiOptionFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveNewContentElementWizardOptionsFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RemoveWorkspaceModeOptionsFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RenameConfigXhtmlDoctypeToDoctypeFractor;
use a9f\Typo3Fractor\TYPO3v12\TypoScript\RenameTcemainLinkHandlerMailKeyFractor;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->autoconfigure()
        ->autowire();

    $services->set(AbstractMessageGetSeverityFluidFractor::class);
    $services->set(MigrateEmailFlagToEmailTypeFlexFormFractor::class);
    $services->set(MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor::class);
    $services->set(MigrateInternalTypeFolderToTypeFolderFlexFormFractor::class);
    $services->set(MigrateNullFlagFlexFormFractor::class);
    $services->set(MigratePasswordAndSaltedPasswordToPasswordTypeFlexFormFractor::class);
    $services->set(MigrateRenderTypeColorpickerToTypeColorFlexFormFractor::class);
    $services->set(MigrateRequiredFlagFlexFormFractor::class);
    $services->set(MigrateTypeNoneColsToSizeFlexFormFractor::class);
    $services->set(RemoveConfigDisablePageExternalUrlFractor::class);
    $services->set(RemoveConfigDoctypeSwitchFractor::class);
    $services->set(RemoveConfigMetaCharsetFractor::class);
    $services->set(RemoveConfigSendCacheHeadersOnlyWhenLoginDeniedInBranchFractor::class);
    $services->set(RemoveConfigSpamProtectEmailAddressesAsciiOptionFractor::class);
    $services->set(RemoveNewContentElementWizardOptionsFractor::class);
    $services->set(RemoveTceFormsDomElementFlexFormFractor::class);
    $services->set(RemoveWorkspaceModeOptionsFractor::class);
    $services->set(RenameConfigXhtmlDoctypeToDoctypeFractor::class);
    $services->set(RenameTcemainLinkHandlerMailKeyFractor::class);
};
