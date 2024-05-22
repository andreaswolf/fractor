<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorYaml\Tests\Fixtures\DummyYamlFractorRule;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../config/application.php')
    ->withRules([DummyYamlFractorRule::class]);
