<?php

declare(strict_types=1);

namespace a9f\FractorXliff\Contract;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\FractorXliff\ValueObject\XliffDocument;

interface XliffFractorRule extends FractorRule
{
    /**
     * Refactor the XLIFF document.
     *
     * Return the (possibly modified) XliffDocument if changes were made,
     * or null if no changes were necessary.
     */
    public function refactor(XliffDocument $xliffDocument): ?XliffDocument;
}
