<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Factory;

use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use a9f\FractorTypoScript\ValueObject\TypoScriptPrettyPrinterFormatConfiguration;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class PrettyPrinterFormatFactory
{
    public function __construct(
        private ContainerBagInterface $parameterBag
    ) {
    }

    public function create(): TypoScriptPrettyPrinterFormatConfiguration
    {
        $size = $this->parameterBag->has(TypoScriptProcessorOption::INDENT_SIZE)
            ? $this->parameterBag->get(TypoScriptProcessorOption::INDENT_SIZE)
            : 4;

        $style = $this->parameterBag->has(TypoScriptProcessorOption::INDENT_CHARACTER)
            ? $this->parameterBag->get(TypoScriptProcessorOption::INDENT_CHARACTER)
            : 'auto';

        $addClosingGlobal = $this->parameterBag->has(TypoScriptProcessorOption::ADD_CLOSING_GLOBAL)
            ? $this->parameterBag->get(TypoScriptProcessorOption::ADD_CLOSING_GLOBAL)
            : true;

        $includeEmptyLineBreaks = $this->parameterBag->has(TypoScriptProcessorOption::INCLUDE_EMPTY_LINE_BREAKS)
            ? $this->parameterBag->get(TypoScriptProcessorOption::INCLUDE_EMPTY_LINE_BREAKS)
            : true;

        $indentConditions = $this->parameterBag->has(TypoScriptProcessorOption::INDENT_CONDITIONS)
            ? $this->parameterBag->get(TypoScriptProcessorOption::INDENT_CONDITIONS)
            : false;

        return TypoScriptPrettyPrinterFormatConfiguration::fromValues(
            $size,
            $style,
            $addClosingGlobal,
            $includeEmptyLineBreaks,
            $indentConditions
        );
    }
}
