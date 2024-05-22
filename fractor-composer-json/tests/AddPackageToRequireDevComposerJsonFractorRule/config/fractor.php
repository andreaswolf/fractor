<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\AddPackageToRequireDevComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;

return FractorConfiguration::configure()
    ->withConfiguredRule(
        AddPackageToRequireDevComposerJsonFractorRule::class,
        [new PackageAndVersion('vendor1/package3', '^3.0')]
    );
