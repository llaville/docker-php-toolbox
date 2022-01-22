<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console;

use Composer\InstalledVersions;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\DependencyInjection\ContainerInterface;

use function sprintf;
use function substr;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class Application extends SymfonyApplication implements ApplicationInterface
{
    private ContainerInterface $container;

    /**
     * Application class constructor.
     */
    public function __construct()
    {
        parent::__construct(
            self::NAME,
            $this->getInstalledVersion(false)
        );
    }

    /**
     * {@inheritDoc}
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function getLongVersion(): string
    {
        return $this->getInstalledVersion();
    }

    public function getInstalledVersion(bool $withRef = true): string
    {
        $packageName = 'bartlett/docker-php-toolbox';

        $version = InstalledVersions::getPrettyVersion($packageName);
        if (!$withRef) {
            return $version;
        }
        $commitHash = InstalledVersions::getReference($packageName);
        return sprintf('%s@%s', $version, substr($commitHash, 0, 7));
    }
}
