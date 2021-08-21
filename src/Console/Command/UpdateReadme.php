<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Console\Command;

use Bartlett\PHPToolbox\Collection\Tool;
use Bartlett\PHPToolbox\Collection\Tools;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function count;
use function file_get_contents;
use function file_put_contents;
use function implode;
use function preg_replace;
use function sprintf;
use function vsprintf;
use const PHP_EOL;

/**
 * @since Release 1.0.0alpha1
 */
final class UpdateReadme extends Command implements CommandInterface
{
    public const NAME = 'update:readme';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('Updates README.md with latest list of available tools and extensions')
            ->addOption(
                'tools',
                null,
                InputOption::VALUE_REQUIRED,
                'Path(s) to the list of tools and extensions.',
                './resources'
            )
            ->addOption(
                'readme',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to the readme file',
                './README.md'
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $toolsPath = $input->getOption('tools');
        $readmePath = $input->getOption('readme');

        $tools = (new Tools())->load($toolsPath)->sortByName();

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
            return in_array('pecl-extensions', $tool->getTags(), true);
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

        $toolsList = $tools->filter(function (Tool $tool) {
            return !in_array('pecl-extensions', $tool->getTags(), true);
        });

        $totalAvailable = [$toolsList->count()];
        foreach ($phpVersions as $phpVersion) {
            $totalAvailable[] = count($toolsList->filter(function (Tool $tool) use ($phpVersion) {
                return !in_array('exclude-php:' . $phpVersion, $tool->getTags());
            }));
        }

        $toolsList = $toolsList->map($formatSection);

        $toolsTable  = '| Name | Description | <sup>PHP 5.2</sup> | <sup>PHP 5.3</sup> | <sup>PHP 5.4</sup> | <sup>PHP 5.5</sup> | <sup>PHP 5.6</sup> | <sup>PHP 7.0</sup> | <sup>PHP 7.1</sup> | <sup>PHP 7.2</sup> | <sup>PHP 7.3</sup> | <sup>PHP 7.4</sup> | <sup>PHP 8.0</sup> | <sup>PHP 8.1</sup> |' . PHP_EOL;
        $toolsTable .= '| :--- | :---------- | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ |' . PHP_EOL;
        $toolsTable .= vsprintf('| | Total available: %d | %d | %d | %d | %d | %d | %d | %d | %d | %d | %d | %d | %d |', $totalAvailable);
        $toolsTable .= PHP_EOL;
        $toolsTable .= implode(PHP_EOL, $toolsList->toArray());
        $toolsTable .= PHP_EOL;

        $readme = file_get_contents($readmePath);
        $readme = preg_replace('/(## Available extensions\n\n).*?(\n#+ )/smi', '$1' . $extensionsTable . '$2', $readme);
        $readme = preg_replace('/(## Available tools\n\n).*?(\n#+ )/smi', '$1' . $toolsTable . '$2', $readme);

        file_put_contents($readmePath, $readme);

        $output->writeln(
            sprintf(
                'The <info>%s</info> was updated with latest tools found in <info>%s</info>.',
                $readmePath,
                $toolsPath
            )
        );

        return self::SUCCESS;
    }
}
