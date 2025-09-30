<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration\ValueObject;

use a9f\Fractor\Application\Contract\FileProcessor;
use a9f\Fractor\Application\Contract\FractorRule;

/**
 * The configuration which paths to skip, optionally narrowed to single rules or processors.
 *
 * @phpstan-type TSkipForRules array<class-string<FractorRule>, string|list<string>>
 * @phpstan-type TSkipForProcessors array<class-string<FileProcessor<FractorRule>>, string|list<string>>
 * @phpstan-type TGlobalSkip array<int, string>
 * @phpstan-type TProcessorSkip array<int, class-string<FileProcessor<FractorRule>>>
 * @phpstan-type TSkipConfiguration TSkipForRules|TSkipForProcessors|TGlobalSkip|TProcessorSkip
 */
final readonly class SkipConfiguration
{
    /**
     * @param TSkipConfiguration $skip
     */
    public function __construct(
        /**
         * @phpstan-var TSkipConfiguration
         */
        private array $skip
    ) {
    }

    /**
     * @return TSkipConfiguration
     */
    public function getSkip(): array
    {
        return $this->skip;
    }
}
