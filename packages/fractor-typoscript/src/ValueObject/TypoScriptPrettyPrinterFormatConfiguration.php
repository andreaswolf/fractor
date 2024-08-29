<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\ValueObject;

use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class TypoScriptPrettyPrinterFormatConfiguration
{
    public function __construct(
        public int $size,
        public string $style,
        public bool $addClosingGlobal,
        public bool $includeEmptyLineBreaks,
        public bool $indentConditions
    ) {
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
