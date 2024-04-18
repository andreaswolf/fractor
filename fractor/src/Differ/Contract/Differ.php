<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\Contract;

use a9f\Fractor\Application\ValueObject\File;

interface Differ
{
    public function diff(File $file): string;
}
