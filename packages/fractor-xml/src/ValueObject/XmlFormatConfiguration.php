<?php

declare(strict_types=1);

namespace a9f\FractorXml\ValueObject;

use a9f\FractorXml\Configuration\XmlProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class XmlFormatConfiguration
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
        $allowedFileExtensions = $parameterBag->has(XmlProcessorOption::ALLOWED_FILE_EXTENSIONS)
            ? $parameterBag->get(XmlProcessorOption::ALLOWED_FILE_EXTENSIONS)
            : ['xml'];
        $allowedFileExtensions = is_array($allowedFileExtensions) ? $allowedFileExtensions : ['xml'];

        return new self($allowedFileExtensions);
    }
}
