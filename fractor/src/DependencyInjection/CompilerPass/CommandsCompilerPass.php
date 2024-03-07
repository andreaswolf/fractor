<?php

namespace a9f\Fractor\DependencyInjection\CompilerPass;

use a9f\Fractor\FractorApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CommandsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $applicationDefinition = $container->getDefinition(FractorApplication::class);

        foreach ($container->getDefinitions() as $name => $definition) {
            if (!is_string($definition->getClass())) {
                continue;
            }

            if (!is_a($definition->getClass(), Command::class, true)) {
                continue;
            }

            $applicationDefinition->addMethodCall('add', [new Reference($name)]);
        }
    }
}
