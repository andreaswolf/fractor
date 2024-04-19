<?php


use a9f\FractorDocGenerator\DependencyInjection\ContainerContainerBuilder;
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
    echo "Could not find autoload.php file";
    exit(1);
}

include $autoloadFile;

$container = (new ContainerContainerBuilder())->createDependencyInjectionContainer();

/** @var FractorDocGeneratorApplication $application */
$application = $container->get(FractorDocGeneratorApplication::class);
$application->run();