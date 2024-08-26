<?php

declare(strict_types=1);

namespace a9f\Fractor\ValueObject;

use a9f\Fractor\Differ\ValueObject\FileDiff;
use Webmozart\Assert\Assert;

class ProcessResult
{
    /**
     * @param FileDiff[] $fileDiffs
     */
    public function __construct(
        private readonly array $fileDiffs
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
