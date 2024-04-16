<?php

namespace a9f\Fractor\Contract;

interface FileProcessor
{
    public function canHandle(\SplFileInfo $file): bool;

    public function handle(\SplFileInfo $file): void;
}
