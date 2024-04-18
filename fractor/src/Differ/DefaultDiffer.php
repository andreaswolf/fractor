<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Differ\Contract\Differ;
use SebastianBergmann\Diff\Differ as CoreDiffer;
use SebastianBergmann\Diff\Output\StrictUnifiedDiffOutputBuilder;

final readonly class DefaultDiffer implements Differ
{
    private CoreDiffer $differ;

    public function __construct()
    {
        $strictUnifiedDiffOutputBuilder = new StrictUnifiedDiffOutputBuilder([
            'fromFile' => 'Original',
            'toFile' => 'New',
        ]);
        $this->differ = new CoreDiffer($strictUnifiedDiffOutputBuilder);
    }

    public function diff(File $file): string
    {
        if (!$file->hasChanged()) {
            return '';
        }

        return $this->differ->diff($file->getOriginalContent(), $file->getContent());
    }
}
