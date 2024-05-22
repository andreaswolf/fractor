<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\ValueObject;

use a9f\FractorComposerJson\ChangePackageVersionComposerJsonFractorRule;
use Webmozart\Assert\Assert;

final readonly class ReplacePackageAndVersion
{
    private string $oldPackageName;

    private string $newPackageName;

    public function __construct(
        string $oldPackageName,
        string $newPackageName,
        private string $version
    ) {
        Assert::notSame(
            $oldPackageName,
            $newPackageName,
            'Old and new package have to be different. If you want to only change package version, use ' . ChangePackageVersionComposerJsonFractorRule::class
        );

        $this->oldPackageName = $oldPackageName;
        $this->newPackageName = $newPackageName;
    }

    public function getOldPackageName(): string
    {
        return $this->oldPackageName;
    }

    public function getNewPackageName(): string
    {
        return $this->newPackageName;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}
