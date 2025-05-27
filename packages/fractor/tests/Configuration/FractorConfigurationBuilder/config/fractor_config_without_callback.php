<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;

$config = FractorConfiguration::configure();
$config->withPaths([dirname(__DIR__, 2)]);
