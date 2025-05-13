<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v14\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/14.0/Breaking-105863-RemoveExposeNonexistentUserInForgotPasswordDialogSettingInExtfelogin.html
 * @see \a9f\Typo3Fractor\Tests\TYPO3v14\TypoScript\RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor\RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractorTest
 */
final class RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'plugin.tx_felogin_login.settings.exposeNonexistentUserInForgotPasswordDialog';
    }
}
