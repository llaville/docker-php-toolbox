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
class ConsoleOptionsResolver extends AbstractOptionsResolver
{
    public function factory(): Options
    {
        return new OptionsFactory($this->defaults);
    }
}
