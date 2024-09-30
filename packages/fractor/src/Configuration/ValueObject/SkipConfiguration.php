<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

final class SkipConfiguration
{
    /**
     * @var string[]
     * @readonly
     */
    private array $skip;

    /**
     * @param string[] $skip
     */
    public function __construct(array $skip)
    {
        $this->skip = $skip;
    }

    /**
     * @return string[] $skip
     */
    public function getSkip(): array
    {
        return $this->skip;
    }
}
