<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

/**
 * Console command contract.
 *
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
interface CommandInterface
{
    public const PHP_VERSIONS_ALLOWED = '5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3, 8.4, 8.5';
}
