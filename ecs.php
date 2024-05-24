<?php

declare(strict_types=1);

return (include __DIR__ . '/.build/ecs.php')
    ->withPaths([__DIR__ . '/e2e', __DIR__ . '/src'])
    ->withRootFiles()
;
