<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Application\RuleSkipper;

use a9f\Fractor\Application\RuleSkipper;
use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;
use a9f\Fractor\DependencyInjection\FractorContainerFactory;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\FileSystem\Skipper\FileInfoMatcher;
use a9f\Fractor\Tests\Application\RuleSkipper\Fixture\RuleA;
use a9f\Fractor\Tests\Application\RuleSkipper\Fixture\RuleB;
use a9f\Fractor\ValueObject\Bootstrap\BootstrapConfigs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class RuleSkipperTest extends TestCase
{
    private ?ContainerInterface $currentContainer = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currentContainer = (new FractorContainerFactory())
            ->createDependencyInjectionContainer(new BootstrapConfigs());
    }

    #[Test]
    public function rulesConfiguredWithoutFilenameAreSkippedForAllFiles(): void
    {
        $configuration = new SkipConfiguration([RuleA::class]);

        $subject = new RuleSkipper($configuration, $this->getService(FileInfoMatcher::class));

        self::assertTrue($subject->shouldSkip(RuleA::class, 'foo/bar.txt'));
        self::assertTrue($subject->shouldSkip(RuleA::class, 'baz.xml'));
        self::assertFalse($subject->shouldSkip(RuleB::class, 'foo/bar.txt'));
        self::assertFalse($subject->shouldSkip(RuleB::class, 'baz.xml'));
    }

    #[Test]
    public function rulesConfiguredWithoutExactPathAreOnlySkippedForThisPath(): void
    {
        $configuration = new SkipConfiguration([
            RuleA::class => 'foo/bar.txt',
        ]);

        $subject = new RuleSkipper($configuration, $this->getService(FileInfoMatcher::class));

        self::assertTrue($subject->shouldSkip(RuleA::class, 'foo/bar.txt'));
        self::assertFalse($subject->shouldSkip(RuleA::class, 'baz.xml'));
        self::assertFalse($subject->shouldSkip(RuleB::class, 'foo/bar.txt'));
        self::assertFalse($subject->shouldSkip(RuleB::class, 'baz.xml'));
    }

    #[Test]
    public function rulesConfiguredWithWildcardInFolderAreSkippedForAllMatchingFiles(): void
    {
        $configuration = new SkipConfiguration([
            RuleA::class => 'foo/*.txt',
            RuleB::class => '*.xml',
        ]);

        $subject = new RuleSkipper($configuration, $this->getService(FileInfoMatcher::class));

        self::assertTrue($subject->shouldSkip(RuleA::class, 'foo/bar.txt'));
        self::assertFalse($subject->shouldSkip(RuleA::class, 'baz.xml'));
        self::assertFalse($subject->shouldSkip(RuleB::class, 'foo/bar.txt'));
        self::assertTrue($subject->shouldSkip(RuleB::class, 'baz.xml'));
    }

    #[Test]
    public function rulesConfiguredWithGlobstarAreSkippedForAllFilesInSubfolders(): void
    {
        $configuration = new SkipConfiguration([
            RuleA::class => 'foo/**/*.txt',
            RuleB::class => '*.xml',
        ]);

        $subject = new RuleSkipper($configuration, $this->getService(FileInfoMatcher::class));

        self::assertTrue($subject->shouldSkip(RuleA::class, 'foo/bar/baz.txt'));
        self::assertTrue($subject->shouldSkip(RuleA::class, 'foo/bar/baz/one.txt'));
        self::assertFalse($subject->shouldSkip(RuleA::class, 'baz.xml'));
        self::assertFalse($subject->shouldSkip(RuleB::class, 'foo/bar/baz.txt'));
        self::assertFalse($subject->shouldSkip(RuleB::class, 'foo/bar/baz/one.txt'));
    }

    #[Test]
    public function rulesConfiguredWithGlobstarForFilenameAreSkippedForFilesInGlobstarFolder(): void
    {
        // "globstars" followed by a / only match 1.. directories, globstars within a filename match all files
        // cf. the description of "globstar" at https://www.gnu.org/savannah-checkouts/gnu/bash/manual/bash.html#The-Shopt-Builtin-1
        $configuration = new SkipConfiguration([
            RuleA::class => 'foo/**/*.txt',
            RuleB::class => 'foo/**.txt',
        ]);

        $subject = new RuleSkipper($configuration, $this->getService(FileInfoMatcher::class));

        self::assertFalse($subject->shouldSkip(RuleA::class, 'foo/bar.txt'));
        self::assertTrue($subject->shouldSkip(RuleB::class, 'foo/bar.txt'));
        self::assertTrue($subject->shouldSkip(RuleB::class, 'foo/bar/baz.txt'));
    }

    /**
     * @template T of object
     * @phpstan-param class-string<T> $type
     * @phpstan-return T
     */
    protected function getService(string $type): object
    {
        if ($this->currentContainer === null) {
            throw new ShouldNotHappenException('Container is not initalized');
        }

        return $this->currentContainer->get($type)
            ?? throw new ShouldNotHappenException(sprintf('Service "%s" was not found', $type));
    }
}
