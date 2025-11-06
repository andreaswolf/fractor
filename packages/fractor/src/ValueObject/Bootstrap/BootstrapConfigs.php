<?php

declare(strict_types=1);

namespace a9f\Fractor\ValueObject\Bootstrap;

final readonly class BootstrapConfigs
{
    /**
     * @param string[] $additionalConfigFiles
     */
    public function __construct(
        private ?string $mainConfigFile = null,
        private array $additionalConfigFiles = [],
    ) {
    }

    public function getMainConfigFile(): ?string
    {
        return $this->mainConfigFile;
    }

    /**
     * @return string[]
     */
    public function getAdditionalConfigFiles(): array
    {
        return $this->additionalConfigFiles;
    }
}
