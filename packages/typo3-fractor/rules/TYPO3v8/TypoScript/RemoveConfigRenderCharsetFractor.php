<?php

declare(strict_types=1);

namespace a9f\Typo3Fractor\TYPO3v8\TypoScript;

use a9f\Typo3Fractor\AbstractRemoveTypoScriptSettingFractor;

/**
 * @changelog https://docs.typo3.org/c/typo3/cms-core/main/en-us/Changelog/8.0/Breaking-73794-RenderCharsetOptionRemoved.html
 */
final class RemoveConfigRenderCharsetFractor extends AbstractRemoveTypoScriptSettingFractor
{
    protected function getFullOptionName(): string
    {
        return 'config.renderCharset';
    }
}
