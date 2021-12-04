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
 * @since Release 1.0.0-beta.2
 * @author Laurent Laville
 */
final class PhiveInstallCommand implements CommandInterface
{
    /** @var string */
    private $alias;
    /** @var string */
    private $sig;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->alias = $properties['alias'];
        $this->sig = $properties['signature'] ?? null;
    }

    public function __toString(): string
    {
        return sprintf(
            'phive --no-progress install %s --global %s',
            $this->sig ? '--trust-gpg-keys ' . $this->sig : '--force-accept-unsigned',
            $this->alias
        );
    }
}
