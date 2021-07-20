<?php
gc_disable(); // performance boost

if (\Phar::running()) {
    $possibleAutoloadPaths = [
        'phar://devkit.phar/vendor/autoload.php'
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
    throw new RuntimeException(sprintf(
        'Unable to find "config/bootstrap.php" in "%s" paths.',
        implode('", "', $possibleAutoloadPaths)
    ));
}
