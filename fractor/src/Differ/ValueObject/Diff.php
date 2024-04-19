<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObject;

final readonly class Diff
{
    public function __construct(private string $oldContent, private string $newContent)
    {
    }

    public function getOldContent(): string
    {
        return $this->oldContent;
    }

    public function getNewContent(): string
    {
        return $this->newContent;
    }

    public function isDifferent(): bool
    {
        return $this->newContent !== $this->oldContent;
    }
}
