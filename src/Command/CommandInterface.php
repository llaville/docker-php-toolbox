<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Command;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
interface CommandInterface
{
    public function __toString(): string;
}
