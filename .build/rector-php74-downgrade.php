<?php

declare(strict_types=1);

/**
 * Rector config to run for a downgrade to PHP 7.4. This is used during the release process
 */

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withSets([
        \Rector\Set\ValueObject\DowngradeSetList::PHP_74
    ])
    ->withSkip([
        __DIR__ . '/../packages/extension-installer/generated',
        __DIR__ . '/../packages/fractor-rule-generator/templates',
    ])
    ->withPaths([
        __DIR__ . '/../packages',
        __DIR__ . '/../src',
    ]);
