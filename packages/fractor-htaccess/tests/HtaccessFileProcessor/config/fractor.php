<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorHtaccess\Tests\Fixtures\RemoveSetEnvIfRule;

return FractorConfiguration::configure()
    ->withRules([RemoveSetEnvIfRule::class]);
