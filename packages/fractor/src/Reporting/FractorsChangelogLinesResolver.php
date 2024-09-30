<?php

declare(strict_types=1);

namespace a9f\Fractor\Reporting;

use a9f\Fractor\Application\ValueObject\AppliedRule;
use Nette\Utils\Strings;

final class FractorsChangelogLinesResolver
{
    /**
     * @readonly
     */
    private FractorsChangelogResolver $fractorsChangelogResolver;

    public function __construct(FractorsChangelogResolver $fractorsChangelogResolver)
    {
        $this->fractorsChangelogResolver = $fractorsChangelogResolver;
    }

    /**
     * @param AppliedRule[] $appliedRules
     * @return string[]
     */
    public function createFractorChangelogLines(array $appliedRules): array
    {
        $rectorsChangelogs = $this->fractorsChangelogResolver->resolveIncludingMissing($appliedRules);

        $fractorsChangelogsLines = [];
        foreach ($rectorsChangelogs as $fractorClass => $changelog) {
            $fractorShortClass = (string) Strings::after($fractorClass, '\\', -1);
            $fractorsChangelogsLines[] = $changelog === null ? $fractorShortClass : $fractorShortClass . ' (' . $changelog . ')';
        }

        return $fractorsChangelogsLines;
    }
}
