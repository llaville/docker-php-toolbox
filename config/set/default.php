<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Bartlett\PHPToolbox\Console\Command\CommandInterface;

use Psr\Container\ContainerInterface;

use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/common.php');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
    ;

    // @link https://symfony.com/doc/current/service_container/tags.html#autoconfiguring-tags
    $services->instanceof(CommandInterface::class)
        ->tag('console.command')
    ;

    // @see https://github.com/symfony/dependency-injection/commit/9591cba6e215ce688fcc301cc6eef1e39daa5ad9 since Symfony 5.1
    $services->alias(ContainerInterface::class, 'service_container');
    $services->alias(SymfonyContainerInterface::class, 'service_container');

    $services->load('Bartlett\\PHPToolbox\\', __DIR__ . '/../../src');
};
