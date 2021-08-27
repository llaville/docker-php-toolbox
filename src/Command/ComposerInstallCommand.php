<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

/**
 * @since Release 1.0.0alpha1
 */
final class ComposerInstallCommand implements CommandInterface
{
    /** @var bool|null  */
    private $scripts;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->scripts = $properties['scripts'] ?? false;
    }

    public function __toString(): string
    {
        $commandLine = 'composer install --no-dev --prefer-dist --no-interaction';
        if (!$this->scripts) {
            $commandLine .= ' --no-scripts';
        }

        return $commandLine;
    }
}
