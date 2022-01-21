<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0-alpha.3
 * @author Laurent Laville
 */
final class PipInstallCommand implements CommandInterface
{
    private int $pipVersion;
    private string $requirement;

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
