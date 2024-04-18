<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Skipper\SkipCriteriaResolver\SkippedPathsResolver;

use a9f\Fractor\Skipper\FileSystem\PathNormalizer;
use a9f\Fractor\Skipper\SkipCriteriaResolver\SkippedPathsResolver;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;

final class SkippedPathsResolverTest extends AbstractFractorTestCase
{
    private SkippedPathsResolver $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getService(SkippedPathsResolver::class);
    }

    public function test(): void
    {
        $skippedPaths = $this->subject->resolve();

        self::assertCount(2, $skippedPaths);

        self::assertSame(PathNormalizer::normalize(__DIR__ . '/Fixtures'), $skippedPaths[0]);
        self::assertSame('*/Mask/*', $skippedPaths[1]);
    }

    protected function additionalConfigurationFiles(): array
    {
        return [__DIR__ . '/config/config.php'];
    }
}
