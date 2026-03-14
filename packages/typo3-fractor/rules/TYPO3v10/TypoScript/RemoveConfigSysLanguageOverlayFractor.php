<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v10\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/10.0/Breaking-87193-DeprecatedFunctionalityRemoved.html
 */
final class RemoveConfigSysLanguageOverlayFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'config.sys_language_overlay';
    }
}
