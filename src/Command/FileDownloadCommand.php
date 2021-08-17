<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

/**
 * @since Release 1.0.0alpha1
 */
final class FileDownloadCommand implements CommandInterface
{
    private $url;
    private $target;

    public function __construct(string $url, string $target)
    {
        $this->url = $url;
        $this->target = $target;
    }

    public function __toString(): string
    {
        return sprintf('curl -Ls %s -o %s', $this->url, $this->target);
    }
}
