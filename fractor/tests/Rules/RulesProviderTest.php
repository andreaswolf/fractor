<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Rules;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Application\RuleSkipper;
use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;
use a9f\Fractor\DependencyInjection\ContainerContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\Fractor\FileSystem\Skipper\FileInfoMatcher;
use a9f\Fractor\Rules\RulesProvider;
use a9f\Fractor\Tests\Application\RuleSkipper\Fixture\RuleA;
use a9f\Fractor\Tests\Application\RuleSkipper\Fixture\RuleB;
use a9f\Fractor\Tests\Fixture\DummyProcessor\Contract\TextRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Webmozart\Assert\InvalidArgumentException;

final class RulesProviderTest extends TestCase
{
    private ?ContainerInterface $currentContainer = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currentContainer = (new ContainerContainerBuilder())
            ->createDependencyInjectionContainer(null);
    }

    #[Test]
    public function getApplicableRulesReturnsAllRulesMatchingClass(): void
    {
        $subject = new RulesProvider([new RuleA(), new RuleB()], FractorRule::class, $this->getService(
            RuleSkipper::class
        ));

        $result = iterator_to_array(
            $subject->getApplicableRules(new File('does/not/matter.txt', 'Lorem ipsum dolor.'))
        );

        self::assertCount(2, $result);
        self::assertInstanceOf(RuleA::class, $result[0]);
        self::assertInstanceOf(RuleB::class, $result[1]);
    }

    #[Test]
    public function constructorThrowsExceptionIfRuleOfDifferentClassIsPassed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new RulesProvider([new RuleA()], TextRule::class, $this->getService(RuleSkipper::class));
    }

    #[Test]
    public function getApplicableRulesDoesNotReturnRuleMarkedAsSkippedByRuleSkipper(): void
    {
        $configuration = new SkipConfiguration([
            RuleA::class => 'foo/**/*.txt',
            RuleB::class => 'foo/**.txt',
        ]);
        $ruleSkipper = new RuleSkipper($configuration, $this->getService(FileInfoMatcher::class));

        $subject = new RulesProvider([new RuleA(), new RuleB()], FractorRule::class, $ruleSkipper);

        $result = iterator_to_array($subject->getApplicableRules(new File('not-skipped.txt', 'Lorem ipsum dolor.')));
        self::assertCount(2, $result);

        $result = iterator_to_array(
            $subject->getApplicableRules(new File('foo/skipped-RuleB.txt', 'Lorem ipsum dolor.'))
        );
        self::assertCount(1, $result);
        self::assertInstanceOf(RuleA::class, $result[0]);

        $result = iterator_to_array(
            $subject->getApplicableRules(new File('foo/bar/skipped-all-rules.txt', 'Lorem ipsum dolor.'))
        );
        self::assertCount(0, $result);
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
