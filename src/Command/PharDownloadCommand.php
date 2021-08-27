<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0alpha1
 */
final class PharDownloadCommand implements CommandInterface
{
    /** @var string  */
    private $phar;
    /** @var string  */
    private $bin;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->phar = $properties['phar'];
        $this->bin = $properties['bin'];
    }

    public function __toString(): string
    {
        return sprintf(
            'curl -Ls %s -o %s && chmod +x %s',
            $this->phar,
            $this->bin,
            $this->bin
        );
    }
}
