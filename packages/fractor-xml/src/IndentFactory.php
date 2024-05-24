<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Configuration\XmlProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class IndentFactory
{
    public function __construct(
        private ContainerBagInterface $parameterBag
    ) {
    }

    public function create(): Indent
    {
        $size = $this->parameterBag->has(XmlProcessorOption::INDENT_SIZE) ? $this->parameterBag->get(
            XmlProcessorOption::INDENT_SIZE
        ) : 4;
        $style = $this->parameterBag->has(XmlProcessorOption::INDENT_CHARACTER) ? $this->parameterBag->get(
            XmlProcessorOption::INDENT_CHARACTER
        ) : Indent::STYLE_SPACE;

        return Indent::fromSizeAndStyle($size, $style);
    }
}
