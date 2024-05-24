<?php

declare(strict_types=1);

use a9f\FractorDocGenerator\DependencyInjection\ContainerBuilderFactory;
use a9f\FractorDocGenerator\FractorDocGeneratorApplication;

$autoloadFile = (static function (): ?string {
    $candidates = [
        getcwd() . '/vendor/autoload.php',
        __DIR__ . '/../../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
    ];
    foreach ($candidates as $candidate) {
        if (file_exists($candidate)) {
            return $candidate;
        }
    }
    return null;
})();
if ($autoloadFile === null) {
    echo 'Could not find autoload.php file';
    exit(1);
}

include $autoloadFile;

$container = (new ContainerBuilderFactory())->createDependencyInjectionContainer();

/** @var FractorDocGeneratorApplication $application */
$application = $container->get(FractorDocGeneratorApplication::class);
$application->run();
