<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Release\ReleaseWorker;

use a9f\FractorMonorepo\Release\FractorApplicationReleaseWriter;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

final readonly class UpdateFractorApplicationReleaseVersionWorker implements ReleaseWorkerInterface
{
    public function __construct(
        private FractorApplicationReleaseWriter $fractorApplicationReleaseWriter,
        private VersionUtils $versionUtils
    ) {
    }

    public function getDescription(Version $version): string
    {
        return $this->fractorApplicationReleaseWriter->getDescription($this->getVersionDev($version));
    }

    public function work(Version $version): void
    {
        $this->fractorApplicationReleaseWriter->write($this->getVersionDev($version));
    }

    private function getVersionDev(Version $version): string
    {
        return $this->versionUtils->getNextAliasFormat($version);
    }
}
