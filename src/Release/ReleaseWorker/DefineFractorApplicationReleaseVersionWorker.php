<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Release\ReleaseWorker;

use a9f\FractorMonorepo\Release\FractorApplicationReleaseWriter;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

final class DefineFractorApplicationReleaseVersionWorker implements ReleaseWorkerInterface
{
    /**
     * @readonly
     */
    private FractorApplicationReleaseWriter $fractorApplicationReleaseWriter;

    public function __construct(FractorApplicationReleaseWriter $fractorApplicationReleaseWriter)
    {
        $this->fractorApplicationReleaseWriter = $fractorApplicationReleaseWriter;
    }

    public function getDescription(Version $version): string
    {
        return $this->fractorApplicationReleaseWriter->getDescription($version->getVersionString());
    }

    public function work(Version $version): void
    {
        $this->fractorApplicationReleaseWriter->write($version->getVersionString());
    }
}
