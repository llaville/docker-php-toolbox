<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Collection;

use Bartlett\PHPToolbox\Command\CommandInterface;

/**
 * @since Release 1.0.0alpha1
 */
final class Tool
{
    private $name;
    private $summary;
    private $website;
    private $command;
    private $testCommand;
    private $tags;

    public function __construct(
        string $name,
        string $summary,
        string $website,
        array $tags,
        ?CommandInterface $command,
        $testCommand
    ) {
        $this->name = $name;
        $this->summary = $summary;
        $this->website = $website;
        $this->tags = $tags;
        $this->command = $command;
        $this->testCommand = $testCommand;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function getCommand(): ?CommandInterface
    {
        return $this->command;
    }

    public function getTestCommand()
    {
        return $this->testCommand;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
