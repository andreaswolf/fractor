<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\ValueObject;

final class PackageAndVersion
{
    /**
     * @readonly
     */
    private string $packageName;

    /**
     * @readonly
     */
    private string $version;

    public function __construct(string $packageName, string $version)
    {
        $this->packageName = $packageName;
        $this->version = $version;
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
