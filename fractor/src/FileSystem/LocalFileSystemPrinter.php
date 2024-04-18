<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

use a9f\Fractor\Contract\FilePrinter;
use a9f\Fractor\ValueObject\File;
use Nette\Utils\FileSystem;

final class LocalFileSystemPrinter implements FilePrinter
{
    public function printFile(File $file): void
    {
        FileSystem::write($file->getFilePath(), $file->getContent());
    }
}
