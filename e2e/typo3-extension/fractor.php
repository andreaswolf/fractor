<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\TYPO3v13\TypoScript\MigrateIncludeTypoScriptSyntaxFractor;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/result/'])
    ->withRules([MigrateIncludeTypoScriptSyntaxFractor::class]);
