<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\TYPO3v10\TypoScript\RemoveConfigUsernameSubstTokenFractor;

return FractorConfiguration::configure()
    ->withRules([RemoveConfigUsernameSubstTokenFractor::class]);
