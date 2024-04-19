<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Helper\Rules;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Tests\Helper\Contract\TextRule;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class ReplaceXXXTextRule implements TextRule
{
    public function apply(File $file): void
    {
        $newFileContent = str_replace('XXX', 'YYY', $file->getContent());

        $file->changeFileContent($newFileContent);
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Replace string XXX with YYY',
            [
                new CodeSample('Replace string XXX with YYY', 'Replace string YYY with YYY')
            ]
        );
    }
}
