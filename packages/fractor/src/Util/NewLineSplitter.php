<?php

declare(strict_types=1);

namespace a9f\Fractor\Util;

use Nette\Utils\Strings;

final class NewLineSplitter
{
    /**
     * @see https://regex101.com/r/qduj2O/4
     */
    private const NEWLINES_REGEX = "#\r?\n#";

    /**
     * @return string[]
     */
    public static function split(string $content): array
    {
        return Strings::split($content, self::NEWLINES_REGEX);
    }
}
