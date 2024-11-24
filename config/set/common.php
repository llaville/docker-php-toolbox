<?php declare(strict_types=1);

use Bartlett\PHPToolbox\Console\Application;
use Bartlett\PHPToolbox\Console\ApplicationInterface;
use Bartlett\PHPToolbox\Console\Command\FactoryCommandLoader;
use Bartlett\PHPToolbox\Console\Input\Input;
use Bartlett\PHPToolbox\Console\Output\Output;
use Bartlett\PHPToolbox\Event\EventDispatcher;
use Bartlett\PHPToolbox\Event\ProfileEventSubscriber;

use Psr\Container\ContainerInterface;

use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Stopwatch\Stopwatch;

use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

/**
 * Build the Container with common parameters and services
 *
 * @param ContainerConfigurator $containerConfigurator
 * @return void
 * @since 1.0.0
 */
return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire();

    $services->set(InputInterface::class, Input::class);
    $services->set(OutputInterface::class, Output::class);

    $services->set(Stopwatch::class);

    $services->set(EventSubscriberInterface::class, ProfileEventSubscriber::class);
    $services->set(EventDispatcherInterface::class, EventDispatcher::class);

    // @link https://symfony.com/doc/current/console/lazy_commands.html#factorycommandloader
    $services->set(CommandLoaderInterface::class, FactoryCommandLoader::class)
        ->arg('$commands', tagged_iterator('console.command'))
    ;

    $services->set(ContainerInterface::class, Container::class);

    $services->set(ApplicationInterface::class, Application::class)
        // for bin file (toolkit.php)
        ->public()
    ;
};
