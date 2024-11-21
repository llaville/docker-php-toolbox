<?php
gc_disable(); // performance boost

if (Phar::running()) {
    $possibleAutoloadPaths = [
        dirname(__FILE__, 2) . '/vendor/autoload.php'
    ];
} else {
    $possibleAutoloadPaths = [
        // local dev repository
        __DIR__ . '/../vendor/autoload.php',
        // dependency
        __DIR__ . '/../../../../vendor/autoload.php',
    ];
}

$isAutoloadFound = false;
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (file_exists($possibleAutoloadPath)) {
        require_once $possibleAutoloadPath;
        $isAutoloadFound = true;
        break;
    }
}

if ($isAutoloadFound === false) {
    fwrite(
        STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );
    exit(1);
}
