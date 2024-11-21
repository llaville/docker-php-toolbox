<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console;

use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
interface ApplicationInterface
{
    public const NAME = 'Helper to discover and install PHP extensions and/or tools';

    /**
     * Gets the name of the application.
     */
    public function getName(): string;

    /**
     * Gets the current version installed of the application.
     */
    public function getInstalledVersion(bool $withRef = true): string;
}
