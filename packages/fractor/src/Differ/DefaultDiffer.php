<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ;

use a9f\Fractor\Differ\Contract\Differ;
use a9f\Fractor\Differ\ValueObject\Diff;
use SebastianBergmann\Diff\Differ as CoreDiffer;
use SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;

final class DefaultDiffer implements Differ
{
    /**
     * @readonly
     */
    private CoreDiffer $differ;

    public function __construct()
    {
        $strictUnifiedDiffOutputBuilder = new StrictUnifiedDiffOutputBuilder([
            'fromFile' => 'Original',
            'toFile' => 'New',
        ]);
        $this->differ = new CoreDiffer($strictUnifiedDiffOutputBuilder);
    }

    public function diff(Diff $diff): string
    {
        if (! $diff->isDifferent()) {
            return '';
        }
        return $this->differ->diff($diff->getOldContent(), $diff->getNewContent());
    }
}
