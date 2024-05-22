<?php

declare(strict_types=1);

namespace a9f\Fractor\Application;

use a9f\Fractor\Application\Contract\FileWriter;
use a9f\Fractor\Application\ValueObject\File;
use Nette\Utils\FileSystem;

final class LocalFileSystemWriter implements FileWriter
{
    public function write(File $file): void
    {
        FileSystem::write($file->getFilePath(), $file->getContent());
    }
}
