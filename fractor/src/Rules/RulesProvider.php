<?php

declare(strict_types=1);

namespace a9f\Fractor\Rules;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\RuleSkipper;
use a9f\Fractor\Application\ValueObject\File;
use Webmozart\Assert\Assert;

/**
 * @template T of FractorRule
 */
final readonly class RulesProvider
{
    /**
     * @param iterable<T> $rules
     * @param class-string<T> $baseClassOrInterface
     */
    public function __construct(
        private iterable $rules,
        private string $baseClassOrInterface,
        private RuleSkipper $ruleSkipper
    ) {
        Assert::allIsInstanceOf($this->rules, $this->baseClassOrInterface);
    }

    /**
     * @return \Generator<int, T, void, void>
     */
    public function getApplicableRules(File $file): \Generator
    {
        foreach ($this->rules as $rule) {
            if ($this->ruleSkipper->shouldSkip($rule::class, $file->getFilePath())) {
                continue;
            }

            yield $rule;
        }
    }
}
