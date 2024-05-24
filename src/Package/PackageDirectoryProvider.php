<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Package;

final class PackageDirectoryProvider
{
    public function getPackageDirectory(): string
    {
        return __DIR__ . '/../../packages';
    }
}
