<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\TYPO3v10\Yaml\TranslationFileFractor;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../../../../config/application.php')
    ->withRules([TranslationFileFractor::class]);
