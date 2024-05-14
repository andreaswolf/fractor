<?php

declare(strict_types=1);

namespace a9f\Fractor\Helper;

class StringUtility
{
    /**
     * Check if an item exists in a comma-separated list of items.
     *
     * @param string $list Comma-separated list of items (string)
     * @param string $item Item to check for
     * @return bool TRUE if $item is in $list
     *
     * @see GeneralUtility::inList in TYPO3 Core
     */
    public static function inList(string $list, string $item): bool
    {
        return str_contains(',' . $list . ',', ',' . $item . ',');
    }
}
