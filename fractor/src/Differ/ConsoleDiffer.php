<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Differ\Contract\Differ;
use a9f\Fractor\Differ\Formatter\ColorConsoleDiffFormatter;
use SebastianBergmann\Diff\Differ as CoreDiffer;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

final readonly class ConsoleDiffer implements Differ
{
    private CoreDiffer $differ;

    public function __construct(
        private ColorConsoleDiffFormatter $colorConsoleDiffFormatter
    ) {
        $unifiedDiffOutputBuilder = new UnifiedDiffOutputBuilder();
        $this->differ = new CoreDiffer($unifiedDiffOutputBuilder);
    }

    public function diff(File $file): string
    {
        $diff = $this->differ->diff($file->getOriginalContent(), $file->getContent());
        return $this->colorConsoleDiffFormatter->format($diff);
    }
}
