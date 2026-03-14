<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v7\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/7.0/Breaking-62888-RemoveUniqueLinkVars.html
 */
final class RemoveConfigUniqueLinkVarsFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'config.uniqueLinkVars';
    }
}
