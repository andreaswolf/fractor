<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Release\ReleaseWorker;

use a9f\FractorMonorepo\Release\FractorApplicationReleaseWriter;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

final readonly class DefineFractorApplicationReleaseVersionWorker implements ReleaseWorkerInterface
{
    public function __construct(
        private FractorApplicationReleaseWriter $fractorApplicationReleaseWriter
    ) {
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
