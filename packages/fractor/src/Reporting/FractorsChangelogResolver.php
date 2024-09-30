<?php

declare(strict_types=1);

namespace a9f\Fractor\Reporting;

use a9f\Fractor\Application\ValueObject\AppliedRule;

final class FractorsChangelogResolver
{
    /**
     * @readonly
     */
    private ChangelogExtractor $changelogExtractor;

    public function __construct(ChangelogExtractor $changelogExtractor)
    {
        $this->changelogExtractor = $changelogExtractor;
    }

    /**
     * @param AppliedRule[] $appliedRules
     * @return array<class-string, string|null>
     */
    public function resolveIncludingMissing(array $appliedRules): array
    {
        $fractorClassesToChangelogUrls = [];
        foreach ($appliedRules as $appliedRule) {
            $fractorClass = $appliedRule->getFractorRule();
            $changelogUrl = $this->changelogExtractor->extractChangelogFromRule($fractorClass);
            $fractorClassesToChangelogUrls[$fractorClass] = $changelogUrl;
        }

        return $fractorClassesToChangelogUrls;
    }
}
