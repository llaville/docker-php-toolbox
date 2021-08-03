<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use Doctrine\Common\Collections\ArrayCollection;

use function count;
use function current;
use function key;

/**
 * @since Release 1.0.0
 */
final class Factory
{
    public static function create(array $command): ?CommandInterface
    {
        $makeCommand = function(string $type, array $properties): ?CommandInterface {
            switch ($type) {
                case 'file-download':
                    return new FileDownloadCommand($properties['url'], $properties['target']);
                case 'phar-download':
                    return new PharDownloadCommand($properties['phar'], $properties['bin']);
                case 'sh':
                    return new ShCommand($properties['cmd'], $properties['package_manager'] ?? '');
            }

            return null;
        };

        if (count($command) > 1) {
            $collection = new ArrayCollection();
            foreach ($command as $type => $properties) {
                $collection->add($makeCommand($type, $properties));
            }
            return new MultiCommand($collection);
        }
        $type = key($command);
        $properties = current($command);
        return $makeCommand($type, $properties);
    }
}
