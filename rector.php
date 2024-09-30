<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\DowngradeLevelSetList;

return RectorConfig::configure()
    ->withPhpSets(false, false, false, false, true)
    ->withSets([DowngradeLevelSetList::DOWN_TO_PHP_74])
    ->withPreparedSets(true, false, false, true, false, false, false, true, true)
    ->withImportNames(true, true, false, true)
    ->withSkip([
        __DIR__ . '/packages/extension-installer/generated',
        __DIR__ . '/packages/fractor-rule-generator/',
        __DIR__ . '/packages/fractor-doc-generator/',
        __DIR__ . '/packages/typo3-fractor/rules/TYPO3v12/FlexForm/',
        __DIR__ . '/packages/typo3-fractor/rules/TYPO3v12/TypoScript/',
        __DIR__ . '/packages/*/tests/*',
        __DIR__ . '/packages/*/rules-tests/*',
    ])
    ->withPaths([
        __DIR__ . '/ecs.php',
        __DIR__ . '/packages',
        __DIR__ . '/rector.php',
        __DIR__ . '/src',
        __DIR__ . '/monorepo-builder.php',
    ]);
