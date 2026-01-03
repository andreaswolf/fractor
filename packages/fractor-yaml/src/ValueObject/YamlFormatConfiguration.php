<?php

declare(strict_types=1);

namespace a9f\FractorYaml\ValueObject;

use a9f\FractorYaml\Configuration\YamlProcessorOption;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final readonly class YamlFormatConfiguration
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
        $allowedFileExtensions = $parameterBag->has(YamlProcessorOption::ALLOWED_FILE_EXTENSIONS)
            ? $parameterBag->get(YamlProcessorOption::ALLOWED_FILE_EXTENSIONS)
            : ['yaml', 'yml'];

        return new self($allowedFileExtensions);
    }
}
