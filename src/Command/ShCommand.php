<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use RuntimeException;
use function sprintf;

/**
 * @since Release 1.0.0alpha1
 */
final class ShCommand implements CommandInterface
{
    private $command;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $command = $properties['cmd'];
        $packageManager = $properties['package_manager'] ?? '';

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
