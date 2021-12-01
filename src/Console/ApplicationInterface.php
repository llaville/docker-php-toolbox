<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Console;

use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * @since Release 1.0.0alpha1
 */
interface ApplicationInterface extends ContainerAwareInterface
{
    public const NAME = 'Helper to discover and install PHP extensions and/or tools';
    public const VERSION = '1.0.0';

    /**
     * @param CommandLoaderInterface $commandLoader
     * @return void
     */
    public function setCommandLoader(CommandLoaderInterface $commandLoader);
}
