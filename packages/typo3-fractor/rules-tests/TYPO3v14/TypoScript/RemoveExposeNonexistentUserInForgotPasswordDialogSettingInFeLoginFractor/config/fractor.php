<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\TYPO3v14\TypoScript\RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor;

return FractorConfiguration::configure()
    ->withRules([RemoveExposeNonexistentUserInForgotPasswordDialogSettingInFeLoginFractor::class]);
