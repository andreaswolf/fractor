<?php

declare(strict_types=1);

namespace a9f\FractorFluid\ValueObject;

use a9f\FractorFluid\Configuration\FluidProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class FluidFormatConfiguration
{
    /**
     * @param array<non-empty-string> $allowedFileExtensions
     */
    public function __construct(
        public array $allowedFileExtensions
    ) {
    }

    public static function createFromParameterBag(ParameterBagInterface $parameterBag): self
    {
        $allowedFileExtensions = $parameterBag->has(FluidProcessorOption::ALLOWED_FILE_EXTENSIONS)
            ? $parameterBag->get(FluidProcessorOption::ALLOWED_FILE_EXTENSIONS)
            : ['html', 'xml', 'txt'];
        $allowedFileExtensions = is_array($allowedFileExtensions) ? $allowedFileExtensions : ['html', 'xml', 'txt'];

        return new self($allowedFileExtensions);
    }
}
