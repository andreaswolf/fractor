<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\ValueObject;

final readonly class TypoScriptPrettyPrinterFormatConfiguration
{
    public function __construct(
        private int $size,
        private string $style,
        private bool $addClosingGlobal,
        private bool $includeEmptyLineBreaks,
        private bool $indentConditions
    ) {
    }

    /**
     * @phpstan-param \Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConfiguration::INDENTATION_STYLE_* $style
     */
    public static function fromValues(
        int $size,
        string $style,
        bool $addClosingGlobal,
        bool $includeEmptyLineBreaks,
        bool $indentConditions
    ): self {
        return new self($size, $style, $addClosingGlobal, $includeEmptyLineBreaks, $indentConditions);
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getStyle(): string
    {
        return $this->style;
    }

    public function shouldAddClosingGlobal(): bool
    {
        return $this->addClosingGlobal;
    }

    public function shouldIncludeEmptyLineBreaks(): bool
    {
        return $this->includeEmptyLineBreaks;
    }

    public function shouldIndentConditions(): bool
    {
        return $this->indentConditions;
    }
}
