<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader as SymfonyFactoryCommandLoader;

use function get_class;
use function in_array;

/**
 * @since Release 1.0.0alpha1
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
        $blacklist = [];
        $factories = [];

        foreach ($commands as $command) {
            if (in_array(get_class($command), $blacklist)) {
                continue;
            }
            $factories[$command->getName()] = function () use ($command) { return $command; };
        }
        parent::__construct($factories);
    }
}
