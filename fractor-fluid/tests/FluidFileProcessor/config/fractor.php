<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorFluid\Tests\Fixtures\DummyFluidFractorRule;

return FractorConfiguration::configure()
    ->withRules([DummyFluidFractorRule::class]);
