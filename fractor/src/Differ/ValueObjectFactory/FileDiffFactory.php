<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObjectFactory;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Differ\ConsoleDiffer;
use a9f\Fractor\Differ\DefaultDiffer;
use a9f\Fractor\Differ\ValueObject\FileDiff;

final readonly class FileDiffFactory
{
    public function __construct(private DefaultDiffer $defaultDiffer, private ConsoleDiffer $consoleDiffer)
    {
    }

    public function createFileDiff(File $file): FileDiff
    {
        return new FileDiff(
            $this->defaultDiffer->diff($file->getDiff()),
            $this->consoleDiffer->diff($file->getDiff()),
        );
    }
}
