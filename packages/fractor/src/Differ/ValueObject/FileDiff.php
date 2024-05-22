<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObject;

final readonly class FileDiff
{
    public function __construct(
        private string $diff,
        private string $diffConsoleFormatted,
    ) {
    }

    public function getDiff(): string
    {
        return $this->diff;
    }

    public function getDiffConsoleFormatted(): string
    {
        return $this->diffConsoleFormatted;
    }
}
