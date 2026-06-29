<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObjectFactory;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Differ\DefaultDiffer;
use a9f\Fractor\Differ\Formatter\ColorConsoleDiffFormatter;
use a9f\Fractor\Differ\ValueObject\FileDiff;
use a9f\Fractor\FileSystem\FilePathHelper;
use a9f\Fractor\Reporting\FractorsChangelogLinesResolver;

final readonly class FileDiffFactory
{
    public function __construct(
        private DefaultDiffer $defaultDiffer,
        private FilePathHelper $filePathHelper,
        private ColorConsoleDiffFormatter $colorConsoleDiffFormatter,
        private FractorsChangelogLinesResolver $fractorsChangelogLinesResolver,
    ) {
    }

    public function createFileDiff(bool $shouldShowDiffs, File $file): FileDiff
    {
        $relativeFilePath = $this->filePathHelper->relativePath($file->getFilePath());

        $diff = $shouldShowDiffs ? $this->defaultDiffer->diff($file->getOriginalContent(), $file->getContent()) : '';
        $consoleDiff = $shouldShowDiffs ? $this->colorConsoleDiffFormatter->format($diff) : '';

        $fractorsChangelogsLines = $this->fractorsChangelogLinesResolver->createFractorChangelogLines(
            $file->getAppliedRules()
        );
        return new FileDiff(
            $relativeFilePath,
            $diff,
            $consoleDiff,
            $file->getAppliedRules(),
            $fractorsChangelogsLines
        );
    }
}
