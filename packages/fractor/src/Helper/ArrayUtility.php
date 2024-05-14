<?php

declare(strict_types=1);

namespace a9f\Fractor\Helper;

class ArrayUtility
{
    /**
     * @return string[]
     *
     * @see GeneralUtility::trimExplode in TYPO3 Core
     */
    public static function trimExplode(string $delimiter, string $string, bool $removeEmptyValues = false): array
    {
        if ($delimiter === '') {
            throw new \InvalidArgumentException('Please define a correct delimiter');
        }

        $result = explode($delimiter, $string);

        if ($removeEmptyValues) {
            $temp = [];
            foreach ($result as $value) {
                if (trim($value) !== '') {
                    $temp[] = $value;
                }
            }

            $result = $temp;
        }

        return array_map('trim', $result);
    }
}
