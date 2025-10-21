<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Release\ReleaseWorker;

use a9f\FractorMonorepo\Release\FractorInitReleaseWriter;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

final readonly class DefineFractorInitReleaseVersionWorker implements ReleaseWorkerInterface
{
    public function __construct(
        private FractorInitReleaseWriter $fractorInitReleaseWriter
    ) {
    }

    public function getDescription(Version $version): string
    {
        return $this->fractorInitReleaseWriter->getDescription($version->getVersionString());
    }

    public function work(Version $version): void
    {
        $this->fractorInitReleaseWriter->write($version->getVersionString());
    }
}
