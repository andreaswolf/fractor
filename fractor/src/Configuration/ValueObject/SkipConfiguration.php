<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

final readonly class SkipConfiguration
{
    /**
     * @param string[] $skip
     */
    public function __construct(
        private array $skip
    ) {
    }

    /**
     * @return string[] $skip
     */
    public function getSkip(): array
    {
        return $this->skip;
    }
}
