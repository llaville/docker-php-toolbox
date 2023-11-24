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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Exception;
use function count;
use function file_get_contents;
use function file_put_contents;
use function implode;
use function preg_replace;
use function sprintf;
use function vsprintf;
use const PHP_EOL;

/**
 * @since Release 1.0.0-rc.1
 * @author Laurent Laville
 */
final class UpdateTools extends Command implements CommandInterface
{
    public const NAME = 'update:tools';

    /**
     * {@inheritDoc}
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

    /**
     * {@inheritDoc}
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputDir = $input->getOption('input-dir');
        $outputFile = $input->getOption('output-file');

        $tools = (new Tools())->load($inputDir)->sortByName();

        $formatSection = function (Tool $tool) {
            return sprintf(
                '| %s | [%s](%s) | %s | %s | %s | %s |',
                $tool->getName(),
                $tool->getSummary(),
                $tool->getWebsite(),
                in_array('exclude-php:8.0', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:8.1', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:8.2', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:8.3', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;'
            );
        };

        $toolsList = $tools->filter(function (Tool $tool) {
            return (new Filter(['pecl-extensions'], []))($tool);
        });

        $phpVersions = ['5.6', '7.0', '7.1', '7.2', '7.3', '7.4', '8.0', '8.1', '8.2', '8.3'];

        foreach ($phpVersions as $phpVersion) {
            $totalAvailable[] = count($toolsList->filter(function (Tool $tool) use ($phpVersion) {
                return !in_array('exclude-php:' . $phpVersion, $tool->getTags());
            }));
        }

        $totalAvailable = [$toolsList->count()];
        foreach ($phpVersions as $phpVersion) {
            $totalAvailable[] = count($toolsList->filter(function (Tool $tool) use ($phpVersion) {
                return !in_array('exclude-php:' . $phpVersion, $tool->getTags());
            }));
        }

        $toolsList = $toolsList->map($formatSection);

        $toolsTable  = '| Name | Description | <sup>PHP 8.0</sup> | <sup>PHP 8.1</sup> | <sup>PHP 8.2</sup> | <sup>PHP 8.3</sup> |' . PHP_EOL;
        $toolsTable .= '| :--- | :---------- | :------ | :------ | :------ | :------ |' . PHP_EOL;
        $toolsTable .= vsprintf('| | Total available: %d | %d | %d | %d | %d |', $totalAvailable);
        $toolsTable .= PHP_EOL;
        $toolsTable .= implode(PHP_EOL, $toolsList->toArray());
        $toolsTable .= PHP_EOL;

        $markdown = file_get_contents($outputFile);
        $markdown = preg_replace('/(.*)(<!-- MARKDOWN-TABLE:START -->\n).*?(<!-- MARKDOWN-TABLE:END -->\n)(.*)/smi', '$1$2' . $toolsTable . '$3$4', $markdown);

        file_put_contents($outputFile, $markdown);

        $output->writeln(
            sprintf(
                'The <info>%s</info> was updated with latest tools found in <info>%s</info>.',
                $outputFile,
                $inputDir
            )
        );

        return self::SUCCESS;
    }
}
