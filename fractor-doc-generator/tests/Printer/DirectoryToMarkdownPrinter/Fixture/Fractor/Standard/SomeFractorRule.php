<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Tests\Printer\DirectoryToMarkdownPrinter\Fixture\Fractor\Standard;

use a9f\Fractor\Application\Contract\FractorRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class SomeFractorRule implements FractorRule
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Some description', [
            new CodeSample(
                <<<'CODE_SAMPLE'
bad code
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
good code
CODE_SAMPLE
            ),
        ]);
    }
}
