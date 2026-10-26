<?php

declare(strict_types=1);

/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bartlett\PHPToolbox\Console;

use Composer\InstalledVersions;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Process\Process;

use function dirname;
use function file_exists;
use function sprintf;
use function substr;
use function trim;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class Application extends SymfonyApplication implements ApplicationInterface
{
    private const UNKNOWN_VERSION = 'UNKNOWN';

    public function __construct(
        CommandLoaderInterface $commandLoader,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->setCommandLoader($commandLoader);
        $this->setDispatcher($eventDispatcher);

        parent::__construct(
            self::NAME,
            $this->getInstalledVersion()
        );
    }

    /**
     * @inheritDoc
     */
    public function getHelp(): string
    {
        return sprintf(
            '<info>%s</info> version <comment>%s</comment>',
            $this->getName(),
            $this->getVersion()
        );
    }

    /**
     * @inheritDoc
     */
    public function getLongVersion(): string
    {
        return $this->getInstalledVersion();
    }

    public function getInstalledVersion(bool $withRef = true): string
    {
        $packageName = 'bartlett/docker-php-toolbox';

        $installed = InstalledVersions::getAllRawData()[0];

        $prettyVersion = $this->getPrettyVersion(
            $installed['versions'][$packageName]['pretty_version'] ?? self::UNKNOWN_VERSION
        );

        if (!$withRef) {
            return $prettyVersion;
        }
        $commitHash = InstalledVersions::getReference($packageName);
        return sprintf('%s (%s)', $prettyVersion, substr($commitHash, 0, 7));
    }

    /**
     * Provide same information, as `sebastian/version` package will do, but without adding extra dependency.
     *
     * @link https://github.com/sebastianbergmann/version
     * @link https://git-scm.com/docs/git-describe
     */
    private function getPrettyVersion(string $fallback): string
    {
        if (!file_exists(dirname(__DIR__, 2) . '/.git')) {
            return $fallback;
        }

        $process = new Process(['git', 'describe', '--tags', '--exact-match']);
        $process->run();

        if (!$process->isSuccessful()) {
            return $fallback;
        }

        return trim($process->getOutput());
    }
}
