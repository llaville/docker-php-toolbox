<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0-alpha.3
 */
final class PipInstallCommand implements CommandInterface
{
    private $pipVersion;
    private $requirement;

    public function __construct(string $requirement, int $pipVersion)
    {
        $this->requirement = $requirement;
        $this->pipVersion = $pipVersion;
    }

    public function __toString(): string
    {
        return sprintf('pip%d install --no-cache-dir --force-reinstall %s', $this->pipVersion, $this->requirement);
    }
}
