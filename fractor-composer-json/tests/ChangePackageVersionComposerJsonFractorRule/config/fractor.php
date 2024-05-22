<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\ChangePackageVersionComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;

return FractorConfiguration::configure()
    ->withConfiguredRule(
        ChangePackageVersionComposerJsonFractorRule::class,
        [new PackageAndVersion('vendor1/package3', '^15.0')]
    );
