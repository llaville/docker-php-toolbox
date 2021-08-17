<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use RuntimeException;
use function sprintf;
use const PHP_EOL;

/**
 * @since Release 1.0.0alpha1
 */
final class ShCommand implements CommandInterface
{
    private $command;

    public function __construct(string $command, string $packageManager)
    {
        if ('' === $packageManager) {
            $this->command = $command;
        } elseif ('apt' === $packageManager) {
            $this->command = "DEBIAN_FRONTEND=noninteractive apt-get update -qq "
                . " && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y --no-install-recommends --no-install-suggests"
                . " " . $command;
        } else {
            throw new RuntimeException(sprintf('Package Manager "%s" is not supported', $packageManager));
        }
    }

    public function __toString(): string
    {
        return $this->command;
    }
}
