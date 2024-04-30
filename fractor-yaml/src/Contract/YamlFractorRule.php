<?php

declare(strict_types=1);

namespace a9f\FractorYaml\Contract;

use a9f\Fractor\Application\Contract\FractorRule;

interface YamlFractorRule extends FractorRule
{
    /**
     * @param mixed[] $yaml
     * @return mixed[]
     */
    public function refactor(array $yaml): array;
}
