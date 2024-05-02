<?php

declare(strict_types=1);

namespace a9f\FractorXml\Tests\Fixtures;

use a9f\FractorXml\Contract\XmlFractor;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

final class DummyXmlFractor implements XmlFractor
{
    public function getRuleDefinition(): RuleDefinition
    {
        throw new BadMethodCallException('Not implemented yet');
    }

    public function canHandle(\DOMNode $node): bool
    {
        return true;
    }

    public function refactor(\DOMNode $node): \DOMNode|int|null
    {
        foreach ($node->childNodes as $child) {
            if (!$child instanceof \DOMElement) {
                continue;
            }

            if ($child->nodeName !== 'books') {
                continue;
            }
            
            $node->removeChild($child);
        }

        return $node;
    }
}
