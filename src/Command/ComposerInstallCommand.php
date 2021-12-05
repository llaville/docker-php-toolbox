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
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class ComposerInstallCommand implements CommandInterface
{
    /** @var bool  */
    private $scripts;

    /** @var bool */
    private $devDependencies;

    /** @var bool */
    private $global;

    /** @var string[] */
    private $packages;

    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        $this->scripts = $properties['scripts'] ?? false;
        $this->devDependencies = $properties['dev'] ?? false;
        $this->global = $properties['global'] ?? false;
        $this->packages = $properties['packages'] ?? [];
    }

    public function __toString(): string
    {
        $commandLine = sprintf(
            'composer %s%s --prefer-dist --no-interaction',
            $this->global ? 'global ' : '',
            empty($this->packages) ? 'install' : 'require'
        );
        if (!$this->devDependencies && !$this->global) {
            $commandLine .= ' --no-dev';
        }
        if (!$this->scripts) {
            $commandLine .= ' --no-scripts';
        }
        if (!empty($this->packages)) {
            $commandLine .= ' ' . implode(' ', $this->packages);
        }

        if ($this->global) {
            /**
             * Do not run Composer as root/super user, and avoid installation in `/root/.composer` directory
             * @link https://getcomposer.org/root
             */
            $commandLine = sprintf('su -c \'%s\' ${MY_USER}', $commandLine);
        }

        return $commandLine;
    }
}
