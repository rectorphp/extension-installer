<?php

declare(strict_types=1);


namespace Rector\RectorInstaller;

use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Composer\Util\Filesystem as ComposerFilesystem;

final class PluginInstaller
{
    /**
     * @var string
     */
    public const RECTOR_EXTENSION_TYPE = 'rector-extension';

    /**
     * @var string
     */
    public const RECTOR_EXTRA_KEY = 'rector';

    /** @var string */
    private static $generatedFileTemplate = <<<'PHP'
<?php declare(strict_types = 1);
namespace Rector\ExtensionInstaller;
/**
 * This class is generated by rector/extension-installer.
 * @internal
 */
final class GeneratedConfig
{
	public const EXTENSIONS = %s;
	private function __construct()
	{
	}
}

PHP;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var InstalledRepositoryInterface
     */
    private $localRepository;

    /**
     * @var IOInterface
     */
    private $io;

    /**
     * @var InstallationManager
     */
    private $installationManager;

    /**
     * @var string
     */
    private $configurationFile;

    /**
     * @var ComposerFilesystem
     */
    private $composerFilesystem;

    public function __construct(
        Filesystem $filesystem,
        InstalledRepositoryInterface $localRepository,
        IOInterface $io,
        InstallationManager $installationManager,
        ComposerFilesystem $composerFilesystem,
        string $configurationFile
    ) {
        $this->filesystem = $filesystem;
        $this->localRepository = $localRepository;
        $this->io = $io;
        $this->installationManager = $installationManager;
        $this->configurationFile = $configurationFile;
        $this->composerFilesystem = $composerFilesystem;
    }

    public function install()
    {
        $oldGeneratedConfigFileHash = null;
        if ($this->filesystem->isFile($this->configurationFile)) {
            $oldGeneratedConfigFileHash = $this->filesystem->hashFile($this->configurationFile);
        }

        $installedPackages = [];
        $data = [];

        foreach ($this->localRepository->getPackages() as $package) {
            if ($this->shouldSkip($package)) {
                continue;
            }

            $absoluteInstallPath = $this->installationManager->getInstallPath($package);
            $data[$package->getName()] = [
                'install_path' => $absoluteInstallPath,
                'relative_install_path' => $this->composerFilesystem->findShortestPath(dirname($this->configurationFile), $absoluteInstallPath, true),
                'extra' => $package->getExtra()[self::RECTOR_EXTRA_KEY] ?? null,
                'version' => $package->getFullPrettyVersion(),
            ];

            $installedPackages[$package->getName()] = true;
        }

        ksort($data);
        ksort($installedPackages);

        $generatedConfigFileContents = sprintf(self::$generatedFileTemplate, var_export($data, true), true);

        if ($this->filesystem->hashEquals((string)$oldGeneratedConfigFileHash, $generatedConfigFileContents)) {
            return;
        }

        $this->filesystem->writeFile($this->configurationFile, $generatedConfigFileContents);
        $this->io->write('<info>ssch/rector-extension-installer:</info> Extensions installed');


        foreach (array_keys($installedPackages) as $name) {
            $this->io->write(sprintf('> <info>%s:</info> installed', $name));
        }
    }

    private function shouldSkip(PackageInterface $package): bool
    {
        if ($package->getType() === self::RECTOR_EXTENSION_TYPE) {
            return false;
        }

        if (isset($package->getExtra()[self::RECTOR_EXTRA_KEY])) {
            return false;
        }

        return true;
    }
}
