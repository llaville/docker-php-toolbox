<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use Doctrine\Common\Collections\Collection;

use InvalidArgumentException;
use function implode;

/** set command
 * @since Release 1.0.0
 */
final class MultiCommand implements CommandInterface
{
    private $commands;
    private $glue;

    public function __construct(Collection $commands, $glue = ' && ')
    {
        if ($commands->isEmpty()) {
            throw new InvalidArgumentException('Collection of commands cannot be empty.');
        }

        $this->commands = $commands->filter(function ($c) {
            return ($c instanceof CommandInterface);
        });
        $this->glue = $glue;
    }

    public function __toString(): string
    {
        return implode($this->glue, $this->commands->toArray());
    }

}
