<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorComposerJson\RenamePackageComposerJsonFractor;
use a9f\FractorComposerJson\ValueObject\RenamePackage;

return FractorConfiguration::configure()
    ->import(__DIR__ . '/../../../config/application.php')
    ->withConfiguredRule(
        RenamePackageComposerJsonFractor::class,
        [new RenamePackage('foo/bar', 'baz/bar'), new RenamePackage('foo/baz', 'baz/baz')]
    );
