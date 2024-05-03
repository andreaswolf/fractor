<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem;

final class WildcardResolver
{
    /**
     * Resolves all "*" placeholders in $paths via glob()
     *
     * @param string[] $paths
     * @return string[]
     */
    public function resolveAllWildcards(array $paths): array
    {
        $absolutePathsFound = [];
        foreach ($paths as $path) {
            if (\str_contains($path, '*')) {
                $foundPaths = $this->foundInGlob($path);
                $absolutePathsFound = [...$absolutePathsFound, ...$foundPaths];
            } else {
                $absolutePathsFound[] = $path;
            }
        }

        return $absolutePathsFound;
    }

    /**
     * @return string[]
     */
    private function foundInGlob(string $path): array
    {
        /** @var string[] $paths */
        $paths = (array) glob($path);

        return array_filter($paths, static fn (string $path): bool => file_exists($path));
    }
}
