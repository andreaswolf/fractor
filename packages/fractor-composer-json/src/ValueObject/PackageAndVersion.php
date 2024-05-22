<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\ValueObject;

final readonly class PackageAndVersion
{
    public function __construct(
        private string $packageName,
        private string $version
    ) {
    }

    public function getPackageName(): string
    {
        return $this->packageName;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}
