<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\AddPackageToRequireDevComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../config/application.php')
    ->withConfiguredRule(
        AddPackageToRequireDevComposerJsonFractorRule::class,
        [new PackageAndVersion('vendor1/package3', '^3.0')]
    );
