<?php

declare(strict_types=1);

namespace a9f\Fractor\FileSystem\Skipper;

final class FnmatchMatcher
{
    public function match(string $matchingPath, string $filePath): bool
    {
        if (\fnmatch($matchingPath, $filePath)) {
            return \true;
        }

        // in case of relative compare
        return \fnmatch('*/' . $matchingPath, $filePath);
    }
}
