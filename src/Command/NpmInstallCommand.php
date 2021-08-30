<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function implode;
use function sprintf;

/**
 * @since Release 1.0.0-beta.1
 */
final class NpmInstallCommand implements CommandInterface
{
    /** @var string  */
    private $requirement;

    private $flags;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->requirement = $properties['requirement'];
        $this->flags = $properties['flags'] ?? [];
    }

    public function __toString(): string
    {
        return sprintf('npm install %s %s', $this->requirement, implode(' ', $this->flags));
    }
}
