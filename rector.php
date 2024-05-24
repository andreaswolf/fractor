<?php

declare(strict_types=1);

return (include __DIR__ . '/.build/rector.php')
    ->withPaths([
        __DIR__ . '/ecs.php',
        __DIR__ . '/rector.php',
        __DIR__ . '/src',
        __DIR__ . '/monorepo-builder.php',
    ]);
