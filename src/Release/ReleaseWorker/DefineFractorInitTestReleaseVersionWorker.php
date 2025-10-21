<?php

declare(strict_types=1);

namespace a9f\FractorMonorepo\Release\ReleaseWorker;

use a9f\FractorMonorepo\Release\FractorInitTestReleaseWriter;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

final readonly class DefineFractorInitTestReleaseVersionWorker implements ReleaseWorkerInterface
{
    public function __construct(
        private FractorInitTestReleaseWriter $fractorInitTestReleaseWriter
    ) {
    }

    public function getDescription(Version $version): string
    {
        return $this->fractorInitTestReleaseWriter->getDescription($version->getVersionString());
    }

    public function work(Version $version): void
    {
        $this->fractorInitTestReleaseWriter->write($version->getVersionString());
    }
}
