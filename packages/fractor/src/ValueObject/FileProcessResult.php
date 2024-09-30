<?php

declare(strict_types=1);

namespace a9f\Fractor\ValueObject;

use a9f\Fractor\Differ\ValueObject\FileDiff;

class FileProcessResult
{
    /**
     * @readonly
     */
    private ?FileDiff $fileDiff;

    public function __construct(?FileDiff $fileDiff)
    {
        $this->fileDiff = $fileDiff;
    }

    public function getFileDiff(): ?FileDiff
    {
        return $this->fileDiff;
    }
}
