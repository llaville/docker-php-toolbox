#!/usr/bin/env php
<?php
// @link https://www.tomasvotruba.cz/blog/2018/08/02/5-gotchas-of-the-bin-file-in-php-cli-applications/

use Bartlett\PHPToolbox\Console\ApplicationInterface;
use Bartlett\PHPToolbox\DependencyInjection\ContainerFactory;

require_once dirname(__DIR__) . '/config/bootstrap.php';

$container = (new ContainerFactory())->create();
$application = $container->get(ApplicationInterface::class);
exit($application->run());
