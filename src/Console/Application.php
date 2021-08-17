<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Console;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @since Release 1.0.0alpha1
 */
final class Application extends SymfonyApplication implements ApplicationInterface
{
    /** @var ContainerInterface  */
    private $container;

    /**
     * Application class constructor.
     */
    public function __construct()
    {
        parent::__construct(self::NAME, self::VERSION);
    }

    /**
     * {@inheritDoc}
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
