<?php declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/common.php');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
    ;

    $services->load('Bartlett\\PHPToolbox\\', __DIR__ . '/../../src');
};
