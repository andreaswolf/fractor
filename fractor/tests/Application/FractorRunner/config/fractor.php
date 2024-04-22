<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Fractor\Tests\Fixture\DummyProcessor\Rules\ReplaceXXXTextRule;

return FractorConfiguration::configure()
    ->withRules([
        ReplaceXXXTextRule::class
    ])
    ->withPaths(
        [
            __DIR__ . '/../Fixtures/'
        ]
    );
