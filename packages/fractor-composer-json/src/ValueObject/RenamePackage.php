<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson\ValueObject;

final class RenamePackage
{
    /**
     * @readonly
     */
    private string $oldPackageName;

    /**
     * @readonly
     */
    private string $newPackageName;

    public function __construct(string $oldPackageName, string $newPackageName)
    {
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
}
