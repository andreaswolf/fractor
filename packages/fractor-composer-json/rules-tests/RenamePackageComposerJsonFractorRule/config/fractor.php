<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\RenamePackageComposerJsonFractorRule;
use a9f\FractorComposerJson\ValueObject\RenamePackage;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../config/application.php')
    ->withConfiguredRule(
        RenamePackageComposerJsonFractorRule::class,
        [new RenamePackage('foo/bar', 'baz/bar'), new RenamePackage('foo/baz', 'baz/baz')]
    );
