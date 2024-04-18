<?php

declare(strict_types=1);

namespace a9f\Fractor\Contract;

use a9f\Fractor\ValueObject\File;

interface FilePrinter
{
    public function printFile(File $file): void;
}
