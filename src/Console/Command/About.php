<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

use Bartlett\PHPToolbox\Console\ApplicationInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function sprintf;

/**
 * Shows short information about this package.
 *
 * @since Release 1.4.0
 * @author Laurent Laville
 */
final class About extends Command implements CommandInterface
{
    public const NAME = 'about';

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Shows short information about this package')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var ApplicationInterface $app */
        $app = $this->getApplication();

        $lines = [
            sprintf(
                '<info>%s</info> version <comment>%s</comment>',
                $app->getName(),
                $app->getInstalledVersion()
            ),
            sprintf(
                '<comment>Please visit %s for more information.</comment>',
                'https://llaville.github.io/docker-php-toolbox/'
            ),
        ];
        $io->text($lines);

        return self::SUCCESS;
    }
}
