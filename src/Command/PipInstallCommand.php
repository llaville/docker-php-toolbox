<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0-alpha.3
 */
final class PipInstallCommand implements CommandInterface
{
    /** @var int  */
    private $pipVersion;
    /** @var string  */
    private $requirement;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->requirement = $properties['requirement'];
        $this->pipVersion = $properties['pip-version'] ?? 3;
    }

    public function __toString(): string
    {
        return sprintf('pip%d install --no-cache-dir --force-reinstall %s', $this->pipVersion, $this->requirement);
    }
}
