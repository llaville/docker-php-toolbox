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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function count;
use function explode;
use function in_array;
use function is_dir;
use function is_readable;
use function sprintf;
use function ucfirst;
use function wordwrap;
use const PHP_EOL;

/**
 * @since Release 2.5.0
 * @author Laurent Laville
 */
abstract class BaseList extends Command
{
    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $phpVersion = $input->getArgument('version');
        if (!in_array($phpVersion, explode(', ', CommandInterface::PHP_VERSIONS_ALLOWED))) {
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

        $ignored = $input->getOption('exclude-tag');
        $ignored[] = 'exclude-php:' . $phpVersion;

        if ($this instanceof ListExtensions) {
            $tags = ['pecl-extensions'];
            $list = 'extensions';
            $preInstalled = ' The pre-installed PHP extensions are excluded from this list.';
        } else {
            $tags = $input->getOption('tag');
            $ignored[] = 'pecl-extensions';
            $list = 'tools';
            $preInstalled = '';
        }

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

        $io->title(sprintf('%s available for PHP %s', ucfirst($list), $phpVersion));
        $io->table($headers, $rows);
        $io->note(
            sprintf('%d %s available.%s', count($rows), $list, $preInstalled)
        );

        return self::SUCCESS;
    }
}
