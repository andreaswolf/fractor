<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\ValueObject;

use a9f\Fractor\Application\Contract\FractorRule;

final readonly class AppliedRule
{
    /**
     * @param class-string<FractorRule> $fractorClass
     */
    private function __construct(
        private string $fractorClass,
    ) {
    }

    public static function fromRule(FractorRule $fractorRule): self
    {
        return new self($fractorRule::class);
    }

    /**
     * @param class-string<FractorRule> $fractorRule
     */
    public static function fromClassString(string $fractorRule): self
    {
        return new self($fractorRule);
    }

    /**
     * @return class-string<FractorRule>
     */
    public function getFractorClass(): string
    {
        return $this->fractorClass;
    }
}
