<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\Contract;

use a9f\Fractor\Differ\ValueObject\Diff;

interface Differ
{
    public function diff(Diff $diff): string;
}
