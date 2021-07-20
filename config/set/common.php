<?php declare(strict_types=1);

use Bartlett\PHPToolbox\Console\Application;
use Bartlett\PHPToolbox\Console\ApplicationInterface;
use Bartlett\PHPToolbox\Console\Command\FactoryCommandLoader;

use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

/**
 * Build the Container with common parameters and services
 *
 * @param ContainerConfigurator $containerConfigurator
 * @return void
 * @since 1.0.0
 */
return static function (ContainerConfigurator $containerConfigurator): void
{
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire();

    $services->set(InputInterface::class, Input::class);
    $services->set(OutputInterface::class, Output::class);

    // @link https://symfony.com/doc/current/console/lazy_commands.html#factorycommandloader
    $services->set(CommandLoaderInterface::class, FactoryCommandLoader::class)
        ->arg('$commands', tagged_iterator('console.command'))
    ;

    $services->set(ApplicationInterface::class, Application::class)
        ->call('setContainer', [service(ContainerInterface::class)])
        ->call('setCommandLoader', [service(CommandLoaderInterface::class)])
        // for bin file
        ->public()
    ;
};
