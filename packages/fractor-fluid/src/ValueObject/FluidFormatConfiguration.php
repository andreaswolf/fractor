<?php

declare(strict_types=1);

namespace a9f\FractorFluid\ValueObject;

use a9f\FractorFluid\Configuration\FluidProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class FluidFormatConfiguration
{
    /**
     * @param list<non-empty-string> $allowedFileExtensions
     */
    public function __construct(
        public array $allowedFileExtensions
    ) {
    }

    public static function createFromParameterBag(ParameterBagInterface $parameterBag): self
    {
        /** @var list<non-empty-string> $allowedFileExtensions */
        $allowedFileExtensions = $parameterBag->has(FluidProcessorOption::ALLOWED_FILE_EXTENSIONS)
            ? $parameterBag->get(FluidProcessorOption::ALLOWED_FILE_EXTENSIONS)
            : ['html', 'xml', 'txt'];

        return new self($allowedFileExtensions);
    }
}
