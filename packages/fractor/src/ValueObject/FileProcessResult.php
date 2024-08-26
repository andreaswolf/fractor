<?php

declare(strict_types=1);

namespace a9f\Fractor\ValueObject;

use a9f\Fractor\Differ\ValueObject\FileDiff;

class FileProcessResult
{
    public function __construct(
        private readonly ?FileDiff $fileDiff
    ) {
    }

    public function getFileDiff(): ?FileDiff
    {
        return $this->fileDiff;
    }
}
