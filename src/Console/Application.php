<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
        parent::__construct(self::NAME, self::VERSION);
    }

    /**
     * {@inheritDoc}
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
