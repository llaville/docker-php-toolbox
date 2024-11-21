<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Configuration;

/**
 * @author Laurent Laville
 * @since Release 2.0.0
 */
interface Resolver
{
    public function factory(): Options;

    public function getOptions(): array;

    public function getOption(string $name): mixed;
}
