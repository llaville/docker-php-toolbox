<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader as SymfonyFactoryCommandLoader;

use function get_class;
use function in_array;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
class FactoryCommandLoader extends SymfonyFactoryCommandLoader
{
    /**
     * FactoryCommandLoader constructor.
     *
     * @param Command[] $commands
     */
    public function __construct(iterable $commands)
    {
        $blacklist = [UpdateExtensions::class, UpdateTools::class];
        $factories = [];

        foreach ($commands as $command) {
            if (in_array(get_class($command), $blacklist)) {
                continue;
            }
            $factories[$command->getName()] = function () use ($command) {
                return $command;
            };
        }
        parent::__construct($factories);
    }
}
