<?php

namespace a9f\Fractor\Application\Contract;

use a9f\Fractor\Application\ValueObject\File;

interface FileProcessor
{
    public function canHandle(\SplFileInfo $file): bool;

    public function handle(File $file): void;

    /**
     * @return list<non-empty-string>
     */
    public function allowedFileExtensions(): array;
}
