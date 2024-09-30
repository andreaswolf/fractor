<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Configuration\XmlProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final class IndentFactory
{
    /**
     * @readonly
     */
    private ContainerBagInterface $parameterBag;

    public function __construct(ContainerBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
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
