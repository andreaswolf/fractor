<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\PHPUnit\ValueObject;

use a9f\Fractor\ValueObject\ProcessResult;

final readonly class FractorTestResult
{
    public function __construct(
        private string $changedContents,
        private ProcessResult $processResult
    ) {
    }

    public function getChangedContents(): string
    {
        return $this->changedContents;
    }

    /**
     * @return array<string>
     */
    public function getAppliedFractorRules(): array
    {
        $appliedRules = [];
        foreach ($this->processResult->getFileDiffs() as $fileDiff) {
            $appliedRules = \array_merge($appliedRules, $fileDiff->getAppliedRules());
        }
        \sort($appliedRules);
        return \array_unique($appliedRules);
    }
}
