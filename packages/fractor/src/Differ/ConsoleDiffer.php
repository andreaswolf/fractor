<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ;

use a9f\Fractor\Differ\Contract\Differ;
use a9f\Fractor\Differ\Formatter\ColorConsoleDiffFormatter;
use a9f\Fractor\Differ\ValueObject\Diff;
use SebastianBergmann\Diff\Differ as CoreDiffer;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

final class ConsoleDiffer implements Differ
{
    /**
     * @readonly
     */
    private ColorConsoleDiffFormatter $colorConsoleDiffFormatter;

    /**
     * @readonly
     */
    private CoreDiffer $differ;

    public function __construct(
        ColorConsoleDiffFormatter $colorConsoleDiffFormatter
    ) {
        $this->colorConsoleDiffFormatter = $colorConsoleDiffFormatter;
        $unifiedDiffOutputBuilder = new UnifiedDiffOutputBuilder();
        $this->differ = new CoreDiffer($unifiedDiffOutputBuilder);
    }

    public function diff(Diff $diff): string
    {
        $diff = $this->differ->diff($diff->getOldContent(), $diff->getNewContent());
        return $this->colorConsoleDiffFormatter->format($diff);
    }
}
