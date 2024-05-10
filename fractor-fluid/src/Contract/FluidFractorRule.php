<?php

declare(strict_types=1);

namespace a9f\FractorFluid\Contract;

use a9f\Fractor\Application\Contract\FractorRule;

interface FluidFractorRule extends FractorRule
{
    public function refactor(string $fluid): string;
}
