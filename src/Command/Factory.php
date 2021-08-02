<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use function current;
use function key;

/**
 * @since Release 1.0.0
 */
final class Factory
{
    public static function create(array $command): ?CommandInterface
    {
        $type = key($command);
        $properties = current($command);

        switch ($type) {
            case 'phar-download':
                return new PharDownloadCommand($properties['phar'], $properties['bin']);
            case 'sh':
                return new ShCommand($properties['cmd'], $properties['package_manager'] ?? '');
        }

        return null;
    }
}
