<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

use Bartlett\PHPToolbox\Collection\Filter;
use Bartlett\PHPToolbox\Collection\Tool;
use Bartlett\PHPToolbox\Collection\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Exception;
use function count;
use function in_array;
use function is_dir;
use function is_readable;
use function sprintf;
use function wordwrap;
use const PHP_EOL;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class ListTools extends Command implements CommandInterface
{
    public const NAME = 'list:tools';

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('List tools available for a specified version')
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'PHP version. Should be either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0, 8.1 or 8.2'
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

    /**
     * {@inheritDoc}
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $phpVersion = $input->getArgument('version');
        if (!in_array($phpVersion, ['5.6', '7.0', '7.1', '7.2', '7.3', '7.4', '8.0', '8.1', '8.2'])) {
            $io->error(
                sprintf('PHP version specified "%s" is not allowed.', $phpVersion)
            );
            return self::FAILURE;
        }

        $toolsPath = $input->getOption('tools');
        if (!is_dir($toolsPath) || !is_readable($toolsPath)) {
            $io->error(
                sprintf('Resources path specified "%s" does not exists or is not readable.', $toolsPath)
            );
            return self::FAILURE;
        }

        $tools = (new Tools())->load($toolsPath)->sortByName();

        $tags = $input->getOption('tag');
        $ignored = $input->getOption('exclude-tag');

        $ignored[] = 'pecl-extensions';
        $ignored[] = 'exclude-php:' . $phpVersion;

        $transform = function (Tool $tool) {
            return [
                $tool->getName(),
                wordwrap($tool->getSummary(), 40, PHP_EOL, false),
                $tool->getWebsite(),
            ];
        };

        $toolsList = $tools->filter(function (Tool $tool) use ($tags, $ignored) {
            return (new Filter($ignored, $tags))($tool);
        });

        $headers = ['Name', 'Description', 'Website'];
        $rows = $toolsList->map($transform)->toArray();

        $io->title('List available tools for PHP ' . $phpVersion);
        $io->table($headers, $rows);
        $io->note(sprintf('%d tools available.', count($rows)));

        return self::SUCCESS;
    }
}
