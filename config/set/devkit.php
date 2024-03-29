<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/common.php');

    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
    ;

    $services->load('Bartlett\\PHPToolbox\\', __DIR__ . '/../../src');
};
