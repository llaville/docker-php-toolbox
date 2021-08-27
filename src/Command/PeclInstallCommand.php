<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0alpha1
 */
final class PeclInstallCommand implements CommandInterface
{
    /** @var string  */
    private $name;
    /** @var string|null  */
    private $version;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->name = $properties['module_name'];
        $this->version = $properties['version'] ?? null;
    }

    public function __toString(): string
    {
        return sprintf(
            'RUN install-php-extensions %s%s',
            $this->name,
            (empty($this->version) ? '' : '-' . $this->version)
        );
    }
}
