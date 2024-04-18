<?php

declare(strict_types=1);

namespace a9f\Fractor\Console;

use a9f\Fractor\Contract\Output;

final class NullOutput implements Output
{
    public function progressStart(int $max = 0): void
    {
    }

    public function progressAdvance(int $step = 1): void
    {
    }

    public function progressFinish(): void
    {
    }
}
