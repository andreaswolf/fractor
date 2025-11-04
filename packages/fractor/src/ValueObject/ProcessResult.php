<?php

declare(strict_types=1);

namespace a9f\Fractor\ValueObject;

use a9f\Fractor\Differ\ValueObject\FileDiff;
use Webmozart\Assert\Assert;

final readonly class ProcessResult
{
    /**
     * @param FileDiff[] $fileDiffs
     */
    public function __construct(
        private array $fileDiffs
    ) {
        Assert::allIsInstanceOf($this->fileDiffs, FileDiff::class);
    }

    /**
     * @return FileDiff[]
     */
    public function getFileDiffs(): array
    {
        return $this->fileDiffs;
    }
}
