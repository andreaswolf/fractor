<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\ValueObject;

use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class TypoScriptPrettyPrinterFormatConfiguration
{
    /**
     * @readonly
     */
    public int $size;

    /**
     * @readonly
     */
    public string $style;

    /**
     * @readonly
     */
    public bool $addClosingGlobal;

    /**
     * @readonly
     */
    public bool $includeEmptyLineBreaks;

    /**
     * @readonly
     */
    public bool $indentConditions;

    public function __construct(int $size, string $style, bool $addClosingGlobal, bool $includeEmptyLineBreaks, bool $indentConditions)
    {
        $this->size = $size;
        $this->style = $style;
        $this->addClosingGlobal = $addClosingGlobal;
        $this->includeEmptyLineBreaks = $includeEmptyLineBreaks;
        $this->indentConditions = $indentConditions;
    }

    public static function createFromParameterBag(ParameterBagInterface $parameterBag): self
    {
        $size = $parameterBag->has(TypoScriptProcessorOption::INDENT_SIZE)
            ? $parameterBag->get(TypoScriptProcessorOption::INDENT_SIZE)
            : 4;
        $size = is_int($size) ? $size : 4;

        $style = $parameterBag->has(TypoScriptProcessorOption::INDENT_CHARACTER)
            ? $parameterBag->get(TypoScriptProcessorOption::INDENT_CHARACTER)
            : 'auto';
        $style = is_string($style) ? $style : 'auto';

        $addClosingGlobal = $parameterBag->has(TypoScriptProcessorOption::ADD_CLOSING_GLOBAL)
            ? (bool) $parameterBag->get(TypoScriptProcessorOption::ADD_CLOSING_GLOBAL)
            : true;

        $includeEmptyLineBreaks = $parameterBag->has(TypoScriptProcessorOption::INCLUDE_EMPTY_LINE_BREAKS)
            ? (bool) $parameterBag->get(TypoScriptProcessorOption::INCLUDE_EMPTY_LINE_BREAKS)
            : true;

        $indentConditions = $parameterBag->has(TypoScriptProcessorOption::INDENT_CONDITIONS)
            && (bool) $parameterBag->get(TypoScriptProcessorOption::INDENT_CONDITIONS);

        return new self($size, $style, $addClosingGlobal, $includeEmptyLineBreaks, $indentConditions);
    }
}
