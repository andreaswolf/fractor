<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\ValueObject;

use a9f\Fractor\Application\Contract\FractorRule;

final class AppliedRule
{
    /**
     * @var class-string<FractorRule>
     * @readonly
     */
    private string $fractorRule;

    /**
     * @param class-string<FractorRule> $fractorRule
     */
    private function __construct(string $fractorRule)
    {
        $this->fractorRule = $fractorRule;
    }

    public static function fromRule(FractorRule $fractorRule): self
    {
        return new self(get_class($fractorRule));
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
