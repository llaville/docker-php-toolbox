<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class ListTools extends BaseList implements CommandInterface
{
    public const NAME = 'list:tools';

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('List tools available for a specified version')
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'PHP version. Should be either ' . self::PHP_VERSIONS_ALLOWED
            )
            ->addOption(
                'tools',
                null,
                InputOption::VALUE_REQUIRED,
                'Path(s) to the list of tools and extensions',
                './resources'
            )
            ->addOption(
                'tag',
                't',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Filter tools by tags'
            )
            ->addOption(
                'exclude-tag',
                'e',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Exclude some tools by tags',
                []
            )
        ;
    }
}
