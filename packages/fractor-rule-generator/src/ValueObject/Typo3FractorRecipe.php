<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\ValueObject;

use a9f\FractorRuleGenerator\Contract\Typo3FractorTypeInterface;

final readonly class Typo3FractorRecipe
{
    public function __construct(
        private Typo3Version $typo3Version,
        private string $url,
        private string $name,
        private string $description,
        private Typo3FractorTypeInterface $type
    ) {
    }

    public function getChangelogAnnotation(): string
    {
        if ($this->url === '') {
            return '';
        }

        $url = $this->url;
        return <<<EOF

 * @changelog {$url}
EOF;
    }

    public function getMajorVersionPrefixed(): string
    {
        return sprintf('v%d', $this->typo3Version->getMajor());
    }

    public function getMajorVersion(): string
    {
        return (string) $this->typo3Version->getMajor();
    }

    public function getMinorVersionPrefixed(): string
    {
        return sprintf('v%d', $this->typo3Version->getMinor());
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getFractorName(): string
    {
        return $this->name . 'Fractor';
    }

    public function getTestDirectory(): string
    {
        return $this->name . 'Fractor';
    }

    public function getSet(): string
    {
        return sprintf(__DIR__ . '/../../../typo3-fractor/config/typo3-%d.php', $this->getMajorVersion());
    }

    public function getUseImports(): string
    {
        $useImports = '';
        if ($this->url === '') {
            $useImports .= <<<EOF
use a9f\Fractor\Contract\NoChangelogRequired;

EOF;
        }
        return $useImports . $this->type->getUseImports();
    }

    public function getTraits(): string
    {
        return $this->type->getTraits();
    }

    public function getExtendsImplements(): string
    {
        $extendsImplements = $this->type->getExtendsImplements();
        if ($this->url === '') {
            if (str_contains($extendsImplements, 'implements')) {
                $extendsImplements .= ', NoChangelogRequired';
            } else {
                $extendsImplements .= ' implements NoChangelogRequired';
            }
        }
        return $extendsImplements;
    }

    public function getFractorBodyTemplate(): string
    {
        return $this->type->getFractorBodyTemplate();
    }

    public function getFractorTypeFolderName(): string
    {
        return $this->type->getFolderName();
    }

    public function getFractorFixtureFileExtension(): string
    {
        return $this->type->getFractorFixtureFileExtension();
    }
}
