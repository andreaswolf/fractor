<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\RuleCodeSamplePrinter;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\FractorDocGenerator\Printer\DiffCodeSamplePrinter;
use Symplify\RuleDocGenerator\Contract\CodeSampleInterface;
use Symplify\RuleDocGenerator\Contract\RuleCodeSamplePrinterInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final readonly class FractorRuleCodeSamplePrinter implements RuleCodeSamplePrinterInterface
{
    public function __construct(
        private DiffCodeSamplePrinter $diffCodeSamplePrinter,
    ) {
    }

    public function isMatch(string $class): bool
    {
        return is_a($class, FractorRule::class, true);
    }

    public function print(CodeSampleInterface $codeSample, RuleDefinition $ruleDefinition): array
    {
        return $this->diffCodeSamplePrinter->print($codeSample);
    }
}
