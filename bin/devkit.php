#!/usr/bin/env php
<?php
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// @link https://www.tomasvotruba.cz/blog/2018/08/02/5-gotchas-of-the-bin-file-in-php-cli-applications/

use Bartlett\PHPToolbox\Console\ApplicationInterface;
use Bartlett\PHPToolbox\Console\Command\About;
use Bartlett\PHPToolbox\Console\Command\UpdateExtensions;
use Bartlett\PHPToolbox\Console\Command\UpdateTools;
use Bartlett\PHPToolbox\DependencyInjection\ContainerFactory;

require_once dirname(__DIR__) . '/config/bootstrap.php';

$container = (new ContainerFactory())->create(basename(__FILE__, '.php'));
$application = $container->get(ApplicationInterface::class);
$application->add(new About());
$application->add(new UpdateExtensions());
$application->add(new UpdateTools());
$application->run();
