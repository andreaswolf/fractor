<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\TYPO3v8\TypoScript\RemoveModNewPageWizOverrideWithExtensionFractor;

return FractorConfiguration::configure()
    ->withRules([RemoveModNewPageWizOverrideWithExtensionFractor::class]);
