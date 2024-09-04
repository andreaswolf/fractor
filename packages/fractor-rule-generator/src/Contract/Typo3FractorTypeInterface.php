<?php

declare(strict_types=1);

namespace a9f\FractorRuleGenerator\Contract;

interface Typo3FractorTypeInterface extends \Stringable
{
    public function getFolderName(): string;

    public function getUseImports(): string;

    public function getExtendsImplements(): string;

    public function getTraits(): string;

    public function getFractorFixtureFileExtension(): string;

    public function getFractorBodyTemplate(): string;
}
