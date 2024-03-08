<?php

namespace a9f\FractorExtensionInstaller;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

final class InstallerPlugin implements PluginInterface, EventSubscriberInterface
{
    public function activate(Composer $composer, IOInterface $io): void
    {
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }

    public function processEvent(Event $event): void
    {
        $composer = $event->getComposer();
        $installationManager = $composer->getInstallationManager();

        $repositoryManager = $composer->getRepositoryManager();
        $localRepository = $repositoryManager->getLocalRepository();

        $fileToGenerate = __DIR__ . '/../generated/InstalledPackages.php';

        $generator = new PackagesFileGenerator(
            $localRepository,
            $installationManager,
            $fileToGenerate,
        );

        $generator->generate();
    }

    /**
     * @return array<ScriptEvents::*, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'processEvent',
            ScriptEvents::POST_UPDATE_CMD => 'processEvent',
        ];
    }
}
