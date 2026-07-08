<?php

declare(strict_types=1);

namespace a9f\FractorComposerJson;

use a9f\Fractor\ValueObject\Indent;
use a9f\FractorComposerJson\Configuration\ComposerJsonProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

final readonly class IndentFactory
{
    public function __construct(
        private ContainerBagInterface $parameterBag
    ) {
    }

    public function create(): Indent
    {
        $size = $this->parameterBag->has(ComposerJsonProcessorOption::INDENT_SIZE)
            ? $this->parameterBag->get(ComposerJsonProcessorOption::INDENT_SIZE)
            : 4;
        $style = $this->parameterBag->has(ComposerJsonProcessorOption::INDENT_CHARACTER)
            ? $this->parameterBag->get(ComposerJsonProcessorOption::INDENT_CHARACTER)
            : Indent::STYLE_SPACE;

        return Indent::fromSizeAndStyle($size, $style);
    }
}
