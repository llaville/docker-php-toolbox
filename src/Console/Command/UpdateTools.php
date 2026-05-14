<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

use Symfony\Component\Console\Input\InputOption;

/**
 * @since Release 1.0.0-rc.1
 * @author Laurent Laville
 */
final class UpdateTools extends BaseUpdate implements CommandInterface
{
    public const NAME = 'update:tools';

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Updates appendix documentation with latest list of available tools')
            ->addOption(
                'input-dir',
                'i',
                InputOption::VALUE_REQUIRED,
                'Path(s) to the list of tools.',
                './resources'
            )
            ->addOption(
                'output-file',
                'o',
                InputOption::VALUE_REQUIRED,
                'Path to the appendix markdown file',
                './docs/appendix/tools.md'
            )
        ;
    }
}
