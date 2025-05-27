<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ConstFetch\RemovePhpVersionIdCheckRector;

return RectorConfig::configure()
    ->withPhpSets(php82: true)
    ->withPreparedSets(deadCode: true, typeDeclarations: true, earlyReturn: true, strictBooleans: true)
    // removeUnusedImports is false since we had cases where imports only used in Docblocks were removed;
    // additionally, our code style fixer will remove unused imports as well
    ->withImportNames(true, true, false, false)
    ->withSkip([
        __DIR__ . '/packages/extension-installer/generated',
        __DIR__ . '/packages/fractor-rule-generator/templates',
        RemovePhpVersionIdCheckRector::class => [__DIR__ . '/packages/fractor/src/Helper/FileHasher.php'],
    ])
    ->withPaths([
        __DIR__ . '/ecs.php',
        __DIR__ . '/packages',
        __DIR__ . '/rector.php',
        __DIR__ . '/src',
        __DIR__ . '/monorepo-builder.php',
    ]);
