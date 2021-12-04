<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Command;

use function implode;
use function sprintf;

/**
 * @since Release 1.0.0-beta.1
 * @author Laurent Laville
 */
final class NpmInstallCommand implements CommandInterface
{
    /** @var string  */
    private $requirement;

    /** @var string[] */
    private $flags;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->requirement = $properties['requirement'];
        $this->flags = $properties['flags'] ?? [];
    }

    public function __toString(): string
    {
        return sprintf(
            'su -c \'. /opt/nvm/nvm.sh; npm install %s %s\' ${MY_USER}',
            $this->requirement,
            implode(' ', $this->flags)
        );
    }
}
