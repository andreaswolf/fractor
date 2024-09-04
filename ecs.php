<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withConfiguredRule(NoSuperfluousPhpdocTagsFixer::class, [
        'allow_mixed' => true,
    ])
    ->withConfiguredRule(GeneralPhpdocAnnotationRemoveFixer::class, [
        'annotations' => ['throws', 'author', 'package', 'group'],
    ])
    ->withRules([
        NoUnusedImportsFixer::class,
        ArraySyntaxFixer::class,
        StandaloneLineInMultilineArrayFixer::class,
        ArrayOpenerAndCloserNewlineFixer::class,
        DeclareStrictTypesFixer::class,
        LineLengthFixer::class,
        YodaStyleFixer::class,
        OperatorLinebreakFixer::class,
    ])
    ->withSkip([__DIR__ . '/packages/extension-installer/generated'])
    ->withPreparedSets(psr12: true, common: true, symplify: true, cleanCode: true)
    ->withPaths([__DIR__ . '/e2e', __DIR__ . '/src', __DIR__ . '/packages'])
    ->withRootFiles();
