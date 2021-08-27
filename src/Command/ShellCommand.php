<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use Doctrine\Common\Collections\ArrayCollection;

use RuntimeException;
use function implode;
use function is_array;
use function sprintf;

/**
 * @since Release 1.0.0-alpha.3
 */
final class ShellCommand implements CommandInterface
{
    /** @var string[]|string  */
    private $command;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $command = $properties['cmd'];
        $packageManager = $properties['package_manager'] ?? '';

        if (is_array($command)) {
            $collection = new ArrayCollection();
            foreach ($command as $cmd) {
                $collection->add(Factory::create(['shell' => ['cmd' => $cmd]]));
            }
            $this->command = implode(' && ', $collection->toArray());
        } elseif ('' === $packageManager) {
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
