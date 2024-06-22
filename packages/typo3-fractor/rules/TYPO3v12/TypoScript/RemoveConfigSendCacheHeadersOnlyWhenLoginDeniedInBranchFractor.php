<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v12\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/12.0/Breaking-96616-RemoveFrontendLoginModeForPages.html
 */
final class RemoveConfigSendCacheHeadersOnlyWhenLoginDeniedInBranchFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'config.sendCacheHeaders_onlyWhenLoginDeniedInBranch';
    }
}
