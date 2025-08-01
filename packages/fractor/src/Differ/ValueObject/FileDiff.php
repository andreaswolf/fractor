<?php

declare(strict_types=1);

namespace a9f\Fractor\Differ\ValueObject;

use Nette\Utils\Strings;

final readonly class FileDiff
{
    /**
     * @var string
     */
    private const FIRST_LINE_KEY = 'first_line';

    /**
     * @var string
     * @se https://regex101.com/r/AUPIX4/1
     */
    private const FIRST_LINE_REGEX = '#@@(.*?)(?<' . self::FIRST_LINE_KEY . '>\\d+)(.*?)@@#';

    public function __construct(
        private string $relativeFilePath,
        private string $diff,
        private string $diffConsoleFormatted,
        /**
         * @var string[]
         */
        private array $appliedRules = []
    ) {
    }

    public function getRelativeFilePath(): string
    {
        return $this->relativeFilePath;
    }

    public function getAbsoluteFilePath(): ?string
    {
        return \realpath($this->relativeFilePath) ?: null;
    }

    public function getDiff(): string
    {
        return $this->diff;
    }

    public function getDiffConsoleFormatted(): string
    {
        return $this->diffConsoleFormatted;
    }

    /**
     * @return string[]
     */
    public function getAppliedRules(): array
    {
        return $this->appliedRules;
    }

    public function getFirstLineNumber(): ?int
    {
        $match = Strings::match($this->diff, self::FIRST_LINE_REGEX);
        // probably some error in diff
        if (! isset($match[self::FIRST_LINE_KEY])) {
            return null;
        }
        return (int) $match[self::FIRST_LINE_KEY];
    }
}
