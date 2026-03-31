<?php

declare(strict_types=1);

namespace a9f\FractorXliff\ValueObject;

use Webmozart\Assert\Assert;

enum XliffVersion: string
{
    case V1_0 = '1.0';
    case V1_1 = '1.1';
    case V1_2 = '1.2';
    case V2_0 = '2.0';

    private const NAMESPACE_MAP = [
        'urn:oasis:names:tc:xliff:document:1.1' => '1.1',
        'urn:oasis:names:tc:xliff:document:1.2' => '1.2',
        'urn:oasis:names:tc:xliff:document:2.0' => '2.0',
    ];

    public static function fromDomDocument(\DOMDocument $document): self
    {
        $rootElement = $document->documentElement;
        Assert::notNull($rootElement, 'XLIFF document has no root element');

        $localName = $rootElement->localName ?? '';
        Assert::same(
            \strtolower($localName),
            'xliff',
            \sprintf('Expected root element "xliff", got "%s"', $localName)
        );

        $version = $rootElement->getAttribute('version');
        if ($version !== '') {
            $matched = self::tryFrom($version);
            if ($matched !== null) {
                return $matched;
            }
        }

        $namespaceUri = $rootElement->namespaceURI ?? '';
        if (isset(self::NAMESPACE_MAP[$namespaceUri])) {
            return self::from(self::NAMESPACE_MAP[$namespaceUri]);
        }

        throw new \InvalidArgumentException(
            'Could not determine XLIFF version: no version attribute or known namespace found'
        );
    }
}
