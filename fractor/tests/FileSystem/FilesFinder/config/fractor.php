<?php

declare(strict_types=1);

use a9f\Fractor\Configuration\FractorConfiguration;

return FractorConfiguration::configure()
    ->withSkip([__DIR__ . '/../Fixtures/SourceWithBrokenSymlinks/folder2']);
