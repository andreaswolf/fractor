<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v8\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/8.5/Breaking-78549-OverridePagePositionMapWizardViaPageTSconfig.html
 * @see \a9f\Typo3Fractor\Tests\TYPO3v8\TypoScript\RemoveModNewPageWizOverrideWithExtensionFractor\RemoveModNewPageWizOverrideWithExtensionFractorTest
 */
final class RemoveModNewPageWizOverrideWithExtensionFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'mod.web_list.newPageWiz.overrideWithExtension';
    }
}
