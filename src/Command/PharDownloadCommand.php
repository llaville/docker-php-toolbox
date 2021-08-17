<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0alpha1
 */
final class PharDownloadCommand implements CommandInterface
{
    private $phar;
    private $bin;

    public function __construct(string $phar, string $bin)
    {
        $this->phar = $phar;
        $this->bin = $bin;
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
