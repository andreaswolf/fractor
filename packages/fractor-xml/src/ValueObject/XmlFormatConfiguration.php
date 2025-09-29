<?php

declare(strict_types=1);

namespace a9f\FractorXml\ValueObject;

use a9f\FractorXml\Configuration\XmlProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class XmlFormatConfiguration
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
        $allowedFileExtensions = $parameterBag->has(XmlProcessorOption::ALLOWED_FILE_EXTENSIONS)
            ? $parameterBag->get(XmlProcessorOption::ALLOWED_FILE_EXTENSIONS)
            : ['xml'];

        return new self($allowedFileExtensions);
    }
}
