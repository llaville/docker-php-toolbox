<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Collection;

use Bartlett\PHPToolbox\Command\CommandInterface;

/**
 * @since Release 1.0.0alpha1
 */
final class Tool
{
    /** @var string  */
    private $name;
    /** @var string  */
    private $summary;
    /** @var string  */
    private $website;
    /** @var CommandInterface|null  */
    private $command;
    /** @var CommandInterface|null */
    private $testCommand;
    /** @var string[]  */
    private $tags;
    /** @var int */
    private $priority;

    /**
     * Class constructor
     *
     * @param string $name
     * @param string $summary
     * @param string $website
     * @param string[] $tags
     * @param CommandInterface|null $command
     * @param CommandInterface|null $testCommand
     * @param int $priority
     */
    public function __construct(
        string $name,
        string $summary,
        string $website,
        array $tags,
        ?CommandInterface $command,
        ?CommandInterface $testCommand,
        int $priority
    ) {
        $this->name = $name;
        $this->summary = $summary;
        $this->website = $website;
        $this->tags = $tags;
        $this->command = $command;
        $this->testCommand = $testCommand;
        $this->priority = $priority;
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

    public function getTestCommand(): ?CommandInterface
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

    public function getPriority(): int
    {
        return $this->priority;
    }
}
