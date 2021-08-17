<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0-alpha.3
 */
final class GitInstallCommand implements CommandInterface
{
    private $repository;
    private $targetDir;
    private $version;
    private $abbreviate;
    private $matchPattern;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->repository = $properties['repository'] ?? null;
        $this->targetDir = $properties['target-dir'] ?? '.';
        $this->version = $properties['version'] ?? null;
        $this->abbreviate = $properties['abbreviate'] ?? null;
        $this->matchPattern = $properties['match'] ?? null;
    }

    public function __toString(): string
    {
        $commandLine = 'git clone %s %s && cd %s && git checkout %s';

        $version = sprintf(
            '$(git describe %s %s --tags $(git rev-list --tags --max-count=1) 2>/dev/null)',
            $this->abbreviate ? sprintf('--abbrev=%d', $this->abbreviate) : '',
            $this->matchPattern ? '--match "' . $this->matchPattern . '"' : ''
        );

        return sprintf(
            $commandLine,
            $this->repository,
            $this->targetDir,
            $this->targetDir,
            $this->version ?? $version
        );
    }
}
