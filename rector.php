<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPhpSets(php82: true)
    ->withPreparedSets(deadCode: true, typeDeclarations: true, earlyReturn: true, strictBooleans: true)
    ->withImportNames(true, true, false, true)
    ->withSkip([
        __DIR__ . '/packages/extension-installer/generated',
        __DIR__ . '/packages/fractor-rule-generator/templates',
    ])
    ->withPaths([
        __DIR__ . '/ecs.php',
        __DIR__ . '/packages',
        __DIR__ . '/rector.php',
        __DIR__ . '/src',
        __DIR__ . '/monorepo-builder.php',
    ]);
