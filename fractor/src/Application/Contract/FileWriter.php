<?php

declare(strict_types=1);

namespace a9f\Fractor\Application\Contract;

use a9f\Fractor\Application\ValueObject\File;

interface FileWriter
{
    public function write(File $file): void;
}
