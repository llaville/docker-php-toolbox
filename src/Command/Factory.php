<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Command;

use Doctrine\Common\Collections\ArrayCollection;

use function count;
use function current;
use function key;

/**
 * @since Release 1.0.0alpha1
 */
final class Factory
{
    /**
     * @param array<string, array> $command
     * @return CommandInterface|null
     */
    public static function create(array $command): ?CommandInterface
    {
        $makeCommand = function (string $type, array $properties): ?CommandInterface {
            switch ($type) {
                case 'composer-install':
                    return new ComposerInstallCommand($properties);
                case 'file-download':
                    return new FileDownloadCommand($properties);
                case 'git-install':
                    return new GitInstallCommand($properties);
                case 'npm-install':
                    return new NpmInstallCommand($properties);
                case 'pecl-install':
                    return new PeclInstallCommand($properties);
                case 'phar-download':
                    return new PharDownloadCommand($properties);
                case 'pip-install':
                    return new PipInstallCommand($properties);
                case 'shell':
                    return new ShellCommand($properties);
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
