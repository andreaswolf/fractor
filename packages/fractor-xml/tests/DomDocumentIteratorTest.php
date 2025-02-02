<?php

declare(strict_types=1);

namespace a9f\FractorXml\Tests;

use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorXml\Contract\DomNodeVisitor;
use a9f\FractorXml\DomDocumentIterator;
use a9f\FractorXml\Tests\Fixtures\CollectingDomNodeVisitor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DomDocumentIterator::class)]
final class DomDocumentIteratorTest extends TestCase
{
    #[Test]
    public function registeredVisitorIsCalledForXmlRootNode(): void
    {
        $nameCollectingVisitor = $this->getCollectingDomNodeVisitor();

        $document = new \DOMDocument();
        $document->loadXML(<<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Root/>
XML);
        $subject = new DomDocumentIterator([$nameCollectingVisitor]);
        $subject->traverseDocument(new File('does-not-matter.xml', ''), $document);

        self::assertSame([
            'beforeTraversal:#document',
            'enterNode:Root',
            'leaveNode:Root',
            'afterTraversal:#document',
        ], $nameCollectingVisitor->calls);
    }

    #[Test]
    public function traversalEntersAndLeavesChildBeforeLeavingParent(): void
    {
        $nameCollectingVisitor = $this->getCollectingDomNodeVisitor();

        $document = new \DOMDocument();
        $document->loadXML(<<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Root><Child /></Root>
XML);
        $subject = new DomDocumentIterator([$nameCollectingVisitor]);
        $subject->traverseDocument(new File('does-not-matter.xml', ''), $document);

        self::assertSame([
            'beforeTraversal:#document',
            'enterNode:Root',
            'enterNode:Child',
            'leaveNode:Child',
            'leaveNode:Root',
            'afterTraversal:#document',
        ], $nameCollectingVisitor->calls);
    }

    #[Test]
    public function traversalCallsVisitorsInConfiguredOrder(): void
    {
        $calls = [];

        $document = new \DOMDocument();
        $document->loadXML(<<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Root><Child /></Root>
XML);
        $subject = new DomDocumentIterator([
            $this->getCallRecordingDomNodeVisitor('visitor1', $calls),
            $this->getCallRecordingDomNodeVisitor('visitor2', $calls),
        ]);
        $subject->traverseDocument(new File('does-not-matter.xml', ''), $document);

        self::assertSame([
            'visitor1:beforeTraversal:#document',
            'visitor2:beforeTraversal:#document',
            'visitor1:enterNode:Root',
            'visitor2:enterNode:Root',
            'visitor1:enterNode:Child',
            'visitor2:enterNode:Child',
            'visitor1:leaveNode:Child',
            'visitor2:leaveNode:Child',
            'visitor1:leaveNode:Root',
            'visitor2:leaveNode:Root',
            'visitor1:afterTraversal:#document',
            'visitor2:afterTraversal:#document',
        ], $calls);
    }

    #[Test]
    public function traversalVisitsSiblingsInTheirOrderInTheDocument(): void
    {
        $nameCollectingVisitor = $this->getCollectingDomNodeVisitor();

        $document = new \DOMDocument();
        $document->loadXML(<<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Root><ChildOne /><ChildTwo /></Root>
XML);
        $subject = new DomDocumentIterator([$nameCollectingVisitor]);
        $subject->traverseDocument(new File('does-not-matter.xml', ''), $document);

        self::assertSame([
            'beforeTraversal:#document',
            'enterNode:Root',
            'enterNode:ChildOne',
            'leaveNode:ChildOne',
            'enterNode:ChildTwo',
            'leaveNode:ChildTwo',
            'leaveNode:Root',
            'afterTraversal:#document',
        ], $nameCollectingVisitor->calls);
    }

    #[Test]
    public function traversalEntersAndLeavesGrandChildrenBeforeLeavingChildren(): void
    {
        $nameCollectingVisitor = $this->getCollectingDomNodeVisitor();

        $document = new \DOMDocument();
        $document->loadXML(<<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Root><Child><GrandChild /></Child></Root>
XML);
        $subject = new DomDocumentIterator([$nameCollectingVisitor]);
        $subject->traverseDocument(new File('does-not-matter.xml', ''), $document);

        self::assertSame([
            'beforeTraversal:#document',
            'enterNode:Root',
            'enterNode:Child',
            'enterNode:GrandChild',
            'leaveNode:GrandChild',
            'leaveNode:Child',
            'leaveNode:Root',
            'afterTraversal:#document',
        ], $nameCollectingVisitor->calls);
    }

    #[Test]
    public function nodeIsRemovedFromDomIfVisitorReturnsRemoveNode(): void
    {
        $nodeRemovingVisitor = new class() extends CollectingDomNodeVisitor {
            public function enterNode(\DOMNode $node): \DOMNode|int
            {
                parent::enterNode($node);
                if ($node->nodeName === 'Child') {
                    return DomDocumentIterator::REMOVE_NODE;
                }
                return $node;
            }
        };
        $document = new \DOMDocument();
        $document->loadXML(<<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Root><Child><GrandChild /></Child></Root>
XML);
        $subject = new DomDocumentIterator([$nodeRemovingVisitor]);
        $subject->traverseDocument(new File('does-not-matter.xml', ''), $document);

        self::assertSame([
            'beforeTraversal:#document',
            'enterNode:Root',
            'enterNode:Child',
            'leaveNode:Child',
            'leaveNode:Root',
            'afterTraversal:#document',
        ], $nodeRemovingVisitor->calls);

        self::assertXmlStringEqualsXmlString('<Root></Root>', $document->saveXML() ?: '');
    }

    #[Test]
    public function nodeIsReplacedIfVisitorReturnsNewDomNode(): void
    {
        $nodeRemovingVisitor = new class() extends CollectingDomNodeVisitor {
            public function enterNode(\DOMNode $node): \DOMNode|int
            {
                parent::enterNode($node);
                if ($node->nodeName === 'Child') {
                    if ($node->ownerDocument === null) {
                        throw new \RuntimeException('Node does not have an ownerDocument, cannot create element');
                    }

                    return $node->ownerDocument->createElement('NewChild');
                }
                return $node;
            }
        };
        $document = new \DOMDocument();
        $document->loadXML(<<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<Root><Child><GrandChild /></Child></Root>
XML);
        $subject = new DomDocumentIterator([$nodeRemovingVisitor]);
        $subject->traverseDocument(new File('does-not-matter.xml', ''), $document);

        self::assertSame([
            'beforeTraversal:#document',
            'enterNode:Root',
            'enterNode:Child',
            'leaveNode:Child',
            'leaveNode:Root',
            'afterTraversal:#document',
        ], $nodeRemovingVisitor->calls);

        self::assertXmlStringEqualsXmlString('<Root><NewChild></NewChild></Root>', $document->saveXML() ?: '');
    }

    private function getCollectingDomNodeVisitor(): CollectingDomNodeVisitor
    {
        return new CollectingDomNodeVisitor();
    }

    /**
     * @param list<non-empty-string> $recorder
     */
    private function getCallRecordingDomNodeVisitor(string $visitorName, array &$recorder): DomNodeVisitor
    {
        return new class($visitorName, $recorder) implements DomNodeVisitor {
            /**
             * @param list<non-empty-string> $calls
             */
            public function __construct(
                private readonly string $visitorName,
                public array &$calls // only public to please PHPStan
            ) {
            }

            public function beforeTraversal(File $file, \DOMDocument $rootNode): void
            {
                $this->calls[] = sprintf('%s:beforeTraversal:%s', $this->visitorName, $rootNode->nodeName);
            }

            public function enterNode(\DOMNode $node): \DOMNode|int
            {
                $this->calls[] = sprintf('%s:enterNode:%s', $this->visitorName, $node->nodeName);
                return $node;
            }

            public function leaveNode(\DOMNode $node): void
            {
                $this->calls[] = sprintf('%s:leaveNode:%s', $this->visitorName, $node->nodeName);
            }

            public function afterTraversal(\DOMDocument $rootNode): void
            {
                $this->calls[] = sprintf('%s:afterTraversal:%s', $this->visitorName, $rootNode->nodeName);
            }
        };
    }
}
