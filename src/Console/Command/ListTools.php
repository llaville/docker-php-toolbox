<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Console\Command;

use Bartlett\PHPToolbox\Collection\Tool;
use Bartlett\PHPToolbox\Collection\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function count;
use function in_array;
use function is_dir;
use function is_readable;
use function sprintf;

/**
 * @since Release 1.0.0
 */
final class ListTools extends Command implements CommandInterface
{
    public const NAME = 'list:tools';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('List tools available for a specified version')
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'PHP version. Should be either 5.2, 5.3, 5.4, 5.5, 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 or 8.1'
            )
            ->addOption(
                'tools',
                null,
                InputOption::VALUE_REQUIRED,
                'Path(s) to the list of tools and extensions.',
                './resources'
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $phpVersion = $input->getArgument('version');
        if (!in_array($phpVersion, ['5.2', '5.3', '5.4', '5.5', '5.6', '7.0', '7.1', '7.2', '7.3', '7.4', '8.0', '8.1'])) {
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

        $tools = (new Tools())->load($toolsPath);

        $transform = function (Tool $tool) {
            return [
                $tool->getName(),
                $tool->getSummary(),
                $tool->getWebsite(),
            ];
        };

        $toolsList = $tools->filter(function(Tool $tool) use($phpVersion) {
            return
                !in_array('pecl-extensions', $tool->getTags(), true) &&
                !in_array('exclude-php:'.$phpVersion, $tool->getTags(), true)
            ;
        });

        $headers = ['Name', 'Description', 'Website'];
        $rows = $toolsList->map($transform)->toArray();

        $io->title('List available tools for PHP ' . $phpVersion);
        $io->table($headers, $rows);
        $io->note(sprintf('%d tools available.', count($rows)));

        return self::SUCCESS;
    }
}
