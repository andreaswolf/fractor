<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Differ;

use ReflectionProperty;
use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

final class DifferFactory
{
    public static function create(): Differ
    {
        $unifiedDiffOutputBuilder = new UnifiedDiffOutputBuilder('');

        // this is required to show full diffs from start to end
        $contextLinesReflectionProperty = new ReflectionProperty($unifiedDiffOutputBuilder, 'contextLines');
        $contextLinesReflectionProperty->setValue($unifiedDiffOutputBuilder, 10000);

        return new Differ($unifiedDiffOutputBuilder);
    }
}
