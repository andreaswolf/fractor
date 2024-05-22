<?php

declare(strict_types=1);

return (include __DIR__ . '/../../.build/ecs.php')
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
     ;
