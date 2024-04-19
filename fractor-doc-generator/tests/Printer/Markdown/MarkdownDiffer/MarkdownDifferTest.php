<?php

declare(strict_types=1);

namespace a9f\FractorDocGenerator\Tests\Printer\Markdown\MarkdownDiffer;

use a9f\FractorDocGenerator\Printer\Markdown\MarkdownDiffer;
use a9f\FractorDocGenerator\Tests\AbstractTestCase;

final class MarkdownDifferTest extends AbstractTestCase
{
    public function test(): void
    {
        $markdownDiffer = $this->getService(MarkdownDiffer::class);

        $currentDiff = $markdownDiffer->diff('old code', 'new code');
        self::assertStringEqualsFile(__DIR__ . '/Fixture/expected_diff.txt', $currentDiff);
    }
}
