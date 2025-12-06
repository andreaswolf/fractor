<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v14\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/14.0/Breaking-106949-DuplicateDoktypeRestrictionConfigurationRemoved.html
 * @see \a9f\Typo3Fractor\Tests\TYPO3v14\TypoScript\RemoveDuplicateDoktypeRestrictionConfigurationFractor\RemoveDuplicateDoktypeRestrictionConfigurationFractorTest
 */
final class RemoveDuplicateDoktypeRestrictionConfigurationFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'mod.web_list.noViewWithDokTypes';
    }
}
