<?php

declare(strict_types=1);

namespace a9f\FractorXliff;

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXliff\Configuration\XliffProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class IndentFactory
{
    public function __construct(
        private ContainerBagInterface $parameterBag
    ) {
    }

    public function create(): Indent
    {
        $size = $this->parameterBag->has(XliffProcessorOption::INDENT_SIZE) ? $this->parameterBag->get(
            XliffProcessorOption::INDENT_SIZE
        ) : 4;
        $style = $this->parameterBag->has(XliffProcessorOption::INDENT_CHARACTER) ? $this->parameterBag->get(
            XliffProcessorOption::INDENT_CHARACTER
        ) : Indent::STYLE_SPACE;

        return Indent::fromSizeAndStyle($size, $style);
    }
}
