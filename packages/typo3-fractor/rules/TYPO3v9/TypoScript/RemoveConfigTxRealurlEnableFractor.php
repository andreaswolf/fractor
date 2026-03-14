<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v9\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/9.2/Feature-84581-SiteHandling.html
 */
final class RemoveConfigTxRealurlEnableFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'config.tx_realurl_enable';
    }
}
