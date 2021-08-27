<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use Doctrine\Common\Collections\Collection;

use InvalidArgumentException;
use function implode;

/** set command
 * @since Release 1.0.0alpha1
 */
final class MultiCommand implements CommandInterface
{
    /** @var Collection<int, CommandInterface>  */
    private $commands;
    /** @var string  */
    private $glue;

    /**
     * @param Collection<int, CommandInterface> $commands
     * @param string $glue
     */
    public function __construct(Collection $commands, string $glue = ' && ')
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
