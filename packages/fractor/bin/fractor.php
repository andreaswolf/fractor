<?php

declare(strict_types=1);

use a9f\Fractor\Bootstrap\FractorConfigsResolver;
use a9f\Fractor\Console\Application\FractorApplication;
use a9f\Fractor\DependencyInjection\FractorContainerFactory;
use Symfony\Component\Console\Command\Command;

$autoloadFile = (static function (): ?string {
    $candidates = [
        // first try the vendor folder, where fractor is installed to
        __DIR__ . '/../../../autoload.php',
        __DIR__ . '/../vendor/autoload.php',
        // fallback to the project's vendor folder
        getcwd() . '/vendor/autoload.php',
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

$fractorConfigsResolver = new FractorConfigsResolver();

try {
    $configFile = $fractorConfigsResolver->provide();

    $containerContainerBuilder = new FractorContainerFactory();
    $container = $containerContainerBuilder->createDependencyInjectionContainer($configFile);
} catch (\Throwable) {
    exit(Command::FAILURE);
}

/** @var FractorApplication $application */
$application = $container->get(FractorApplication::class);
exit($application->run());
