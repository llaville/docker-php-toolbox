<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Command;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class FileDownloadCommand implements CommandInterface
{
    /** @var string  */
    private $url;
    /** @var string  */
    private $target;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->url = $properties['url'];
        $this->target = $properties['target'];
    }

    public function __toString(): string
    {
        return sprintf('curl -Ls %s -o %s', $this->url, $this->target);
    }
}
