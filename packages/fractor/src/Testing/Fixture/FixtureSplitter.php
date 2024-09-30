<?php

declare(strict_types=1);

namespace a9f\Fractor\Testing\Fixture;

use Nette\Utils\FileSystem;

final class FixtureSplitter
{
    public static function containsSplit(string $fixtureFileContent): bool
    {
        return strpos($fixtureFileContent, "-----\n") !== false || strpos($fixtureFileContent, "-----\r\n") !== false;
    }

    /**
     * @return array<int, string>
     */
    public static function split(string $filePath): array
    {
        $fixtureFileContents = FileSystem::read($filePath);

        return self::splitFixtureFileContents($fixtureFileContents);
    }

    /**
     * @return array<int, string>
     */
    public static function splitFixtureFileContents(string $fixtureFileContents): array
    {
        $fixtureFileContents = str_replace("\r\n", "\n", $fixtureFileContents);
        return explode("-----\n", $fixtureFileContents);
    }
}
