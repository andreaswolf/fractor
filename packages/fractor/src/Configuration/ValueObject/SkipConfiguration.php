<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

use a9f\Fractor\Application\Contract\FractorRule;

/**
 * The configuration which paths to skip, optionally narrowed to single rules.
 *
 * @phpstan-type TSkipForRules array<class-string<FractorRule>, string|list<string>>
 * @phpstan-type TGlobalSkip array<int, string>
 */
final readonly class SkipConfiguration
{
    /**
     * @param TSkipForRules|TGlobalSkip $skip
     */
    public function __construct(
        private array $skip
    ) {
    }

    /**
     * @return TSkipForRules|TGlobalSkip
     */
    public function getSkip(): array
    {
        return $this->skip;
    }
}
