<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class ContainerFactory
{
    public function create(string $set = 'default'): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../../config/set'));
        $loader->load($set . '.php');
        $containerBuilder->compile();
        return $containerBuilder;
    }
}
