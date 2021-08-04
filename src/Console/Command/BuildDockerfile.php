<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Console\Command;

use Bartlett\PHPToolbox\Collection\Tool;
use Bartlett\PHPToolbox\Collection\Tools;

use Bartlett\PHPToolbox\Command\FileDownloadCommand;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use function array_intersect;
use function file_get_contents;
use function file_put_contents;
use function in_array;
use function is_dir;
use function is_file;
use function is_readable;
use function php_uname;
use function preg_replace;
use function sprintf;
use function str_replace;
use function strpos;
use function strtolower;
use const PHP_EOL;

/**
 * @since Release 1.0.0
 */
final class BuildDockerfile extends Command implements CommandInterface
{
    public const NAME = 'build:dockerfile';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('Build a Dockerfile by specified version')
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'PHP version. Should be either 5.2, 5.3, 5.4, 5.5, 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 or 8.1'
            )
            ->addOption(
                'resources',
                null,
                InputOption::VALUE_REQUIRED,
                'Path(s) to the list of tools and extensions.',
                './resources'
            )
            ->addOption(
                'dockerfile',
                'f',
                InputOption::VALUE_REQUIRED,
                'Path to the Dockerfile',
                './Dockerfiles/mods/Dockerfile'
            )
            ->addOption(
                'build-version',
                'B',
                InputOption::VALUE_REQUIRED,
                'Identify which part of image to build from the Dockerfile',
                '2'
            )
            ->addOption(
                'target-dir',
                null,
                InputOption::VALUE_REQUIRED,
                'To perform tools installation in other location than default directory',
                '/usr/local/bin'
            )
            ->addOption(
                'tag',
                't',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Filter tools by tags.'
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

        $resourcesPath = $input->getOption('resources');
        if (!is_dir($resourcesPath) || !is_readable($resourcesPath)) {
            $io->error(
                sprintf('Resources path specified "%s" does not exists or is not readable.', $resourcesPath)
            );
            return self::FAILURE;
        }

        $buildVersion = $input->getOption('build-version');

        $dockerfilePath = $input->getOption('dockerfile');
        $suffix = basename(dirname($dockerfilePath));

        if ('work' === $suffix && $buildVersion) {
            // check if specialized Dockerfile version exists
            $dockerfilePath .= '.' . $buildVersion;
        }

        if (!is_file($dockerfilePath) || !is_readable($dockerfilePath)) {
            $io->error(
                sprintf('Dockerfile specified "%s" does not exists or is not readable.', $dockerfilePath)
            );
            return self::FAILURE;
        }

        if (!in_array($suffix, ['mods', 'work'])) {
            $io->warning('Only mods or work Dockerfile could be rebuild with this command.');
            return self::SUCCESS;
        }

        $tools = (new Tools())->load($resourcesPath);

        if ('mods' === $suffix) {
            $this->applyChangeOnModsDockerfile($dockerfilePath, $tools, $phpVersion, $buildVersion);
        }

        if ('work' === $suffix) {
            $targetDir = $input->getOption('target-dir');
            $tags = $input->getOption('tag');
            $this->applyChangeOnWorkDockerfile($dockerfilePath, $tools, $phpVersion, $targetDir, $tags);
        }

        $io->success(
            sprintf(
                'The Dockerfile specified %s was updated with latest resources found in %s',
                $dockerfilePath,
                $resourcesPath
            )
        );

        return self::SUCCESS;
    }

    private function applyChangeOnModsDockerfile(string $dockerfilePath, Collection $tools, string $phpVersion, string $buildVersion): void
    {
        $extensionsList = $tools->filter(function(Tool $tool) use($phpVersion) {
            return
                in_array('pecl-extensions', $tool->getTags(), true) &&
                !in_array('exclude-php:'.$phpVersion, $tool->getTags(), true)
                ;
        });

        $modulesInstallation = 'FROM builder as build-version-' . $buildVersion . PHP_EOL;
        foreach ($extensionsList as $extension) {
            /** @var Tool $extension */
            $modulesInstallation .= sprintf('RUN install-php-extensions %s', $extension->getName()) . PHP_EOL;
        }

        $dockerfile = file_get_contents($dockerfilePath);
        $dockerfile = preg_replace(
            '/(FROM builder as build-version-1\n)(.*?)(\n###\n)/smi',
            '$1$2' . PHP_EOL . $modulesInstallation . '$3',
            $dockerfile
        );
        file_put_contents($dockerfilePath, $dockerfile);
    }

    private function applyChangeOnWorkDockerfile(string $dockerfilePath, Collection $tools, string $phpVersion, string $targetDir, array $tags): void
    {
        $toolsList = $tools->filter(function(Tool $tool) use($phpVersion, $tags) {
            $preFilter =
                !in_array('pecl-extensions', $tool->getTags(), true) &&
                !in_array('exclude-php:'.$phpVersion, $tool->getTags(), true)
            ;
            if (!$preFilter) {
                return false;
            }
            if (!empty($tags)) {
                $byTags = array_intersect($tool->getTags(), $tags);
                return !empty($byTags);
            }
            return true;
        });

        $softwareInstallation = 'RUN set -eux';
        foreach ($toolsList as $tool) {
            $command = $tool->getCommand();
            $commandLine = (string) $command;
            $os = php_uname('s');
            $arch = php_uname('m');
            $os = strtolower($os);
            $arch = strpos($arch, 'x86') === false ? $arch : '386';
            $commandLine = str_replace(['%os%', '%arch%'], [$os, $arch], $commandLine);
            $commandLine = str_replace('%target-dir%', $targetDir, $commandLine);
            $softwareInstallation .= ' \\' . PHP_EOL . '    && ' . $commandLine;
        }
        $softwareInstallation .= PHP_EOL;

        $dockerfile = file_get_contents($dockerfilePath);
        $dockerfile = preg_replace(
            '/(### Install custom software\n###\n\n).*?(\n###\n)/smi',
            '$1' . $softwareInstallation  . '$2',
            $dockerfile
        );
       file_put_contents($dockerfilePath, $dockerfile);
    }
}
