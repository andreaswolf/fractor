<?php

namespace a9f\Fractor\Configuration;

use Symfony\Component\DependencyInjection\ContainerBuilder;

final class FractorConfig extends ContainerBuilder
{
    /** @var list<non-empty-string> */
    private array $paths = [];

    /** @var list<non-empty-string> */
    private array $fileExtensions = [];

    /**
     * @param non-empty-list<non-empty-string> $paths A list of paths to process
     */
    public function setPaths(array $paths): self
    {
        $this->paths = $paths;
        return $this;
    }

    /**
     * @return list<non-empty-string>
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * @param list<non-empty-string> $extensions
     */
    public function setFileExtensions(array $extensions): self
    {
        $this->fileExtensions = $extensions;

        return $this;
    }

    /**
     * @return list<non-empty-string>
     */
    public function getFileExtensions(): array
    {
        return $this->fileExtensions;
    }

    public function import(string $configFile): void
    {
        if (!file_exists($configFile)) {
            throw new \RuntimeException(sprintf('Config file %s does not exist, cannot import', $configFile));
        }

        $closure = (require $configFile);
        if (!is_callable($closure)) {
            throw new \RuntimeException(sprintf(
                'Fractor config files should return a callable for configuration, %s returned %s instead',
                $configFile,
                get_debug_type($closure)
            ));
        }

        /** @var callable(FractorConfig): void $closure */
        $closure($this);
    }
}
