<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\ValueObject;

use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConditionTermination;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class TypoScriptPrettyPrinterFormatConfiguration
{
    /**
     * @param array<non-empty-string> $allowedFileExtensions
     */
    public function __construct(
        public int $size,
        public string $style,
        public bool $addClosingGlobal,
        public bool $includeEmptyLineBreaks,
        public bool $indentConditions,
        public PrettyPrinterConditionTermination $conditionTermination,
        public array $allowedFileExtensions
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

        /** @var PrettyPrinterConditionTermination $conditionTermination */
        $conditionTermination = $parameterBag->has(TypoScriptProcessorOption::CONDITION_TERMINATION)
            ? $parameterBag->get(TypoScriptProcessorOption::CONDITION_TERMINATION)
            : PrettyPrinterConditionTermination::Keep;

        $allowedFileExtensions = $parameterBag->has(TypoScriptProcessorOption::ALLOWED_FILE_EXTENSIONS)
            ? $parameterBag->get(TypoScriptProcessorOption::ALLOWED_FILE_EXTENSIONS)
            : ['typoscript', 'tsconfig', 'ts'];
        $allowedFileExtensions = is_array($allowedFileExtensions) ? $allowedFileExtensions : [
            'typoscript',
            'tsconfig',
            'ts',
        ];

        return new self(
            $size,
            $style,
            $addClosingGlobal,
            $includeEmptyLineBreaks,
            $indentConditions,
            $conditionTermination,
            $allowedFileExtensions
        );
    }
}
