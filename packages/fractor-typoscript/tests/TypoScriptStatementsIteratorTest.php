<?php

declare(strict_types=1);

namespace a9f\FractorTypoScript\Tests;

use a9f\Fractor\Application\ValueObject\File;
use a9f\Fractor\DependencyInjection\ContainerContainerBuilder;
use a9f\Fractor\Exception\ShouldNotHappenException;
use a9f\FractorTypoScript\Tests\Fixture\StatementCollectingVisitor;
use a9f\FractorTypoScript\TypoScriptStatementsIterator;
use Helmich\TypoScriptParser\Parser\Parser;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class TypoScriptStatementsIteratorTest extends TestCase
{
    private ?ContainerInterface $currentContainer = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->currentContainer = (new ContainerContainerBuilder())
            ->createDependencyInjectionContainer(__DIR__ . '/config/fractor.php', [
                __DIR__ . '/config/config.php',
            ]);
    }

    #[Test]
    public function visitorsAreCalledForAllStatements(): void
    {
        $parser = $this->getService(Parser::class);
        $nodes = $parser->parseString(<<<TS
page = PAGE
page.10 = TEXT
page.10.value = Hello World!
TS);

        $calls = [];
        $subject = new TypoScriptStatementsIterator([new StatementCollectingVisitor('statements', $calls)]);
        $subject->traverseDocument(new File('', ''), $nodes);

        self::assertSame([
            'statements:beforeTraversal:3',
            'statements:enterNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-1',
            'statements:leaveNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-1',
            'statements:enterNode:Helmich\TypoScriptParser\Parser\AST\Operator\ObjectCreation:l-2',
            'statements:leaveNode:Helmich\TypoScriptParser\Parser\AST\Operator\ObjectCreation:l-2',
            'statements:enterNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-3',
            'statements:leaveNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-3',
            'statements:afterTraversal:3',
        ], $calls);
    }

    #[Test]
    public function visitorsAreCalledForAllStatementsWithNesting(): void
    {
        $parser = $this->getService(Parser::class);
        $nodes = $parser->parseString(<<<TS
page = PAGE
page.10 = TEXT
page.10 {
    value = Hello World!
}
TS);

        $calls = [];
        $subject = new TypoScriptStatementsIterator([new StatementCollectingVisitor('statements', $calls)]);
        $subject->traverseDocument(new File('', ''), $nodes);

        self::assertSame([
            'statements:beforeTraversal:3',
            'statements:enterNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-1',
            'statements:leaveNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-1',
            'statements:enterNode:Helmich\TypoScriptParser\Parser\AST\Operator\ObjectCreation:l-2',
            'statements:leaveNode:Helmich\TypoScriptParser\Parser\AST\Operator\ObjectCreation:l-2',
            'statements:enterNode:Helmich\TypoScriptParser\Parser\AST\NestedAssignment:l-3',
            'statements:enterNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-4',
            'statements:leaveNode:Helmich\TypoScriptParser\Parser\AST\Operator\Assignment:l-4',
            'statements:leaveNode:Helmich\TypoScriptParser\Parser\AST\NestedAssignment:l-3',
            'statements:afterTraversal:3',
        ], $calls);
    }

    /**
     * @template T of object
     * @phpstan-param class-string<T> $type
     * @phpstan-return T
     */
    protected function getService(string $type): object
    {
        if ($this->currentContainer === null) {
            throw new ShouldNotHappenException('Container is not initialized');
        }

        return $this->currentContainer->get($type)
            ?? throw new ShouldNotHappenException(sprintf('Service "%s" was not found', $type));
    }
}
