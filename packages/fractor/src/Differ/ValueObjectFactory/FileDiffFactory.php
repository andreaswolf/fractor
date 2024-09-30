<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObjectFactory;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Differ\ConsoleDiffer;
use a9f\Fractor\Differ\DefaultDiffer;
use a9f\Fractor\Differ\ValueObject\FileDiff;
use a9f\Fractor\FileSystem\FilePathHelper;
use a9f\Fractor\Reporting\FractorsChangelogLinesResolver;

final class FileDiffFactory
{
    /**
     * @readonly
     */
    private DefaultDiffer $defaultDiffer;

    /**
     * @readonly
     */
    private ConsoleDiffer $consoleDiffer;

    /**
     * @readonly
     */
    private FilePathHelper $filePathHelper;

    /**
     * @readonly
     */
    private FractorsChangelogLinesResolver $fractorsChangelogLinesResolver;

    public function __construct(DefaultDiffer $defaultDiffer, ConsoleDiffer $consoleDiffer, FilePathHelper $filePathHelper, FractorsChangelogLinesResolver $fractorsChangelogLinesResolver)
    {
        $this->defaultDiffer = $defaultDiffer;
        $this->consoleDiffer = $consoleDiffer;
        $this->filePathHelper = $filePathHelper;
        $this->fractorsChangelogLinesResolver = $fractorsChangelogLinesResolver;
    }

    public function createFileDiff(File $file): FileDiff
    {
        $relativeFilePath = $this->filePathHelper->relativePath($file->getFilePath());
        $fractorsChangelogsLines = $this->fractorsChangelogLinesResolver->createFractorChangelogLines(
            $file->getAppliedRules()
        );
        return new FileDiff(
            $relativeFilePath,
            $this->defaultDiffer->diff($file->getDiff()),
            $this->consoleDiffer->diff($file->getDiff()),
            $fractorsChangelogsLines
        );
    }
}
