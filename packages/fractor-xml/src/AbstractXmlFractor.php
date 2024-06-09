<?php

declare(strict_types=1);

namespace a9f\FractorXml;

use a9f\Fractor\Application\ValueObject\AppliedRule;
use a9f\Fractor\Application\ValueObject\File;
use a9f\FractorXml\Contract\DomNodeVisitor;
use a9f\FractorXml\Contract\XmlFractor;
use Webmozart\Assert\Assert;

abstract class AbstractXmlFractor implements DomNodeVisitor, XmlFractor
{
    protected ?File $file = null;

    public function beforeTraversal(File $file, \DOMDocument $rootNode): void
    {
        $this->file = $file;
    }

    public function enterNode(\DOMNode $node): \DOMNode|int
    {
        Assert::isInstanceOf($this->file, File::class);
        if (! $this->canHandle($node)) {
            return $node;
        }

        $result = $this->refactor($node);

        if ($result === null) {
            return $node;
        }

        $this->file->addAppliedRule(AppliedRule::fromRule($this));
        return $result;
    }

    public function leaveNode(\DOMNode $node): void
    {
        // no-op for now
    }

    public function afterTraversal(\DOMDocument $rootNode): void
    {
        // no-op for now
    }
}
