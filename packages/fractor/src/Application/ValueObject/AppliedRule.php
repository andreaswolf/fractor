<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\ValueObject;

use a9f\Fractor\Application\Contract\FractorRule;

final readonly class AppliedRule
{
    /**
     * @param class-string<FractorRule> $fractorRule
     */
    private function __construct(
        private string $fractorRule,
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
    public function getFractorRule(): string
    {
        return $this->fractorRule;
    }
}
