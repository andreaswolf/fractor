<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\ReplacePackageAndVersionComposerJsonFractor;
use a9f\FractorComposerJson\ValueObject\ReplacePackageAndVersion;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../config/application.php')
    ->withConfiguredRule(
        ReplacePackageAndVersionComposerJsonFractor::class,
        [new ReplacePackageAndVersion('vendor1/package1', 'vendor1/package3', '^4.0')]
    );
