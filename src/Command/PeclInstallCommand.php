<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0
 */
final class PeclInstallCommand implements CommandInterface
{
    private $name;
    private $version;

    public function __construct(string $name, ?string $version = null)
    {
        $this->name = $name;
        $this->version = $version;
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
