<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Command;

use function sprintf;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class PharDownloadCommand implements CommandInterface
{
    private string $phar;
    private string $bin;

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
