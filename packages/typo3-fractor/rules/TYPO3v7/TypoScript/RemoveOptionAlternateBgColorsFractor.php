<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v7\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/7.0/Breaking-53658-RemoveAlternateBgColorsOption.html
 * @see \a9f\Typo3Fractor\Tests\TYPO3v7\TypoScript\RemoveOptionAlternateBgColorsFractor\RemoveOptionAlternateBgColorsFractorTest
 */
final class RemoveOptionAlternateBgColorsFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'mod.web_list.alternateBgColors';
    }
}
