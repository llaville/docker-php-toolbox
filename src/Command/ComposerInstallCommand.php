<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0
 */
final class ComposerInstallCommand implements CommandInterface
{
    private $repository;
    private $targetDir;
    private $version;
    private $scripts;

    public function __construct(string $repository, string $targetDir, ?string $version = null, bool $scripts = true)
    {
        $this->repository = $repository;
        $this->targetDir = $targetDir;
        $this->version = $version;
        $this->scripts = $scripts;
    }

    public function __toString(): string
    {
        $commandLine = 'git clone %s %s && cd %s && git checkout %s && composer install --no-dev --prefer-dist --no-interaction';
        if (!$this->scripts) {
            $commandLine .= ' --no-scripts';
        }

        return sprintf(
            $commandLine,
            $this->repository,
            $this->targetDir,
            $this->targetDir,
            $this->version ?? '$(git describe --tags $(git rev-list --tags --max-count=1) 2>/dev/null)'
        );
    }
}
