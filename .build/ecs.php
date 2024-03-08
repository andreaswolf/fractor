<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    // add a single rule
    ->withRules([
        NoUnusedImportsFixer::class,
        ArraySyntaxFixer::class,
    ])
    ->withPreparedSets(psr12: true)
    ;
