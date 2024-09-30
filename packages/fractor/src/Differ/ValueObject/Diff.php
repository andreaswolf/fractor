<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObject;

final class Diff
{
    /**
     * @readonly
     */
    private string $oldContent;

    /**
     * @readonly
     */
    private string $newContent;

    public function __construct(string $oldContent, string $newContent)
    {
        $this->oldContent = $oldContent;
        $this->newContent = $newContent;
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
