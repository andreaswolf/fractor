<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\RemovePackageComposerJsonFractorRule;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../config/application.php')
    ->withConfiguredRule(
        RemovePackageComposerJsonFractorRule::class,
        ['vendor1/package3', 'vendor1/package1', 'vendor1/package2']
    );
