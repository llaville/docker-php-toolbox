<?php declare(strict_types=1);

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
 */
final class UpdateExtensions extends Command implements CommandInterface
{
    public const NAME = 'update:extensions';

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Updates appendix documentation with latest list of available extensions')
            ->addOption(
                'input-dir',
                'i',
                InputOption::VALUE_REQUIRED,
                'Path(s) to the list of extensions.',
                './resources'
            )
            ->addOption(
                'output-file',
                'o',
                InputOption::VALUE_REQUIRED,
                'Path to the appendix markdown file',
                './docs/appendix/extensions.md'
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
                '| %s | [%s](%s) | %s | %s | %s | %s | %s | %s | %s | %s | %s | %s | %s | %s |',
                $tool->getName(),
                $tool->getSummary(),
                $tool->getWebsite(),
                in_array('exclude-php:5.2', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:5.3', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:5.4', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:5.5', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:5.6', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:7.0', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:7.1', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:7.2', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:7.3', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:7.4', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:8.0', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;',
                in_array('exclude-php:8.1', $tool->getTags(), true) ? '&#x274C;' : '&#x2705;'
            );
        };

        $extensionsList = $tools->filter(function (Tool $tool) {
            return (new Filter([], ['pecl-extensions']))($tool);
        });

        $totalAvailable = [$extensionsList->count()];
        $phpVersions = ['5.2', '5.3', '5.4', '5.5', '5.6', '7.0', '7.1', '7.2', '7.3', '7.4', '8.0', '8.1'];

        foreach ($phpVersions as $phpVersion) {
            $totalAvailable[] = count($extensionsList->filter(function (Tool $tool) use ($phpVersion) {
                return !in_array('exclude-php:' . $phpVersion, $tool->getTags());
            }));
        }

        $extensionsList = $extensionsList->map($formatSection);

        $extensionsTable  = '| Name | Description | <sup>PHP 5.2</sup> | <sup>PHP 5.3</sup> | <sup>PHP 5.4</sup> | <sup>PHP 5.5</sup> | <sup>PHP 5.6</sup> | <sup>PHP 7.0</sup> | <sup>PHP 7.1</sup> | <sup>PHP 7.2</sup> | <sup>PHP 7.3</sup> | <sup>PHP 7.4</sup> | <sup>PHP 8.0</sup> | <sup>PHP 8.1</sup> |' . PHP_EOL;
        $extensionsTable .= '| :--- | :---------- | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ |' . PHP_EOL;
        $extensionsTable .= vsprintf('| | Total available: %d | %d | %d | %d | %d | %d | %d | %d | %d | %d | %d | %d | %d |', $totalAvailable);
        $extensionsTable .= PHP_EOL;
        $extensionsTable .= implode(PHP_EOL, $extensionsList->toArray());
        $extensionsTable .= PHP_EOL;

        $markdown = file_get_contents($outputFile);
        $markdown = preg_replace('/(.*)(<!-- MARKDOWN-TABLE:START -->\n).*?(<!-- MARKDOWN-TABLE:END -->\n)(.*)/smi', '$1$2' . $extensionsTable . '$3$4', $markdown);

        file_put_contents($outputFile, $markdown);

        $output->writeln(
            sprintf(
                'The <info>%s</info> was updated with latest extensions found in <info>%s</info>.',
                $outputFile,
                $inputDir
            )
        );

        return self::SUCCESS;
    }
}