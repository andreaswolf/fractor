<?php

declare(strict_types=1);

namespace a9f\FractorXliff\ValueObject;

use a9f\FractorXliff\Configuration\XliffProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class XliffFormatConfiguration
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
        $allowedFileExtensions = $parameterBag->has(XliffProcessorOption::ALLOWED_FILE_EXTENSIONS)
            ? $parameterBag->get(XliffProcessorOption::ALLOWED_FILE_EXTENSIONS)
            : ['xlf', 'xliff'];

        return new self($allowedFileExtensions);
    }
}
