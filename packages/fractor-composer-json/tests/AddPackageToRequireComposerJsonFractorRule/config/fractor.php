<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\AddPackageToRequireComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\PackageAndVersion;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../config/application.php')
    ->withConfiguredRule(
        AddPackageToRequireComposerJsonFractorRule::class,
        [new PackageAndVersion('vendor1/package3', '^3.0')]
    );
