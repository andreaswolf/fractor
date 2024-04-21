<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Printer;

use a9f\FractorDocGenerator\Printer\Markdown\MarkdownDiffer;
use Symplify\RuleDocGenerator\Contract\CodeSampleInterface;

final readonly class DiffCodeSamplePrinter
{
    public function __construct(private MarkdownDiffer $markdownDiffer)
    {
    }

    /**
     * @return string[]
     */
    public function print(CodeSampleInterface $codeSample): array
    {
        $diffCode = $this->markdownDiffer->diff($codeSample->getBadCode(), $codeSample->getGoodCode());
        return [$diffCode];
    }
}
