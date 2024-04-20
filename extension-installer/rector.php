<?php

declare(strict_types=1);

return (include __DIR__ . '/../.build/rector.php')
    ->withPaths([
        __DIR__ . '/src',
    ]);
