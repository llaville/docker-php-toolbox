<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

use Bartlett\PHPToolbox\Collection\Tool;
use Bartlett\PHPToolbox\Collection\ToolCollectionInterface;
use Bartlett\PHPToolbox\Collection\Tools;
use Bartlett\PHPToolbox\Configuration\ConsoleOptionsResolver;
use Bartlett\PHPToolbox\Configuration\FileOptionsResolver;
use Bartlett\PHPToolbox\Configuration\OptionDefinition;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Exception;
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
use function str_contains;
use function str_replace;
use function strtolower;
use const PHP_EOL;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class BuildDockerfile extends Command implements CommandInterface
{
    public const NAME = 'build:dockerfile';

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Build a Dockerfile by specified version')
            ->addArgument(
                'version',
                InputArgument::OPTIONAL,
                'PHP version. Should be either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0, 8.1, 8.2, 8.3 or 8.4'
            )
            ->addOption(
                'resources',
                null,
                InputOption::VALUE_REQUIRED,
                'Path(s) to the list of tools and extensions (<comment>default: ' . OptionDefinition::DEFAULT_RESOURCES_PATH . '</comment>)'
            )
            ->addOption(
                'dockerfile',
                'f',
                InputOption::VALUE_REQUIRED,
                'Path to the Dockerfile template (<comment>default: ' . OptionDefinition::DEFAULT_DOCKERFILE_PATH . '</comment>)'
            )
            ->addOption(
                'build-version',
                'B',
                InputOption::VALUE_REQUIRED,
                'Build version to identify the final Dockerfile from template (case insensitive)'
            )
            ->addOption(
                'target-dir',
                null,
                InputOption::VALUE_REQUIRED,
                'To perform tools installation in other location than default directory (<comment>default: ' . OptionDefinition::DEFAULT_TARGET_DIR . '</comment>)'
            )
            ->addOption(
                'tag',
                't',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Filter tools by tags'
            )
            ->addOption(
                'configuration',
                'c',
                InputOption::VALUE_REQUIRED,
                'Read configuration from config file',
                OptionDefinition::DEFAULT_CONFIG_FILE
            )
            ->addOption(
                'no-configuration',
                null,
                InputOption::VALUE_NONE,
                'Ignore default configuration file (<comment>' . OptionDefinition::DEFAULT_CONFIG_FILE . '</comment>)'
            )
        ;
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (true === $input->hasParameterOption(['--no-configuration'], true)) {
            $configResolver = new ConsoleOptionsResolver($input);
        } else {
            $configResolver = new FileOptionsResolver($input);
        }

        $phpVersion = $configResolver->getOption(OptionDefinition::PHP_VERSION);
        if (!in_array($phpVersion, ['5.6', '7.0', '7.1', '7.2', '7.3', '7.4', '8.0', '8.1', '8.2', '8.3', '8.4'])) {
            $io->error(
                sprintf('PHP version specified "%s" is not allowed.', $phpVersion)
            );
            return self::FAILURE;
        }

        $resourcesPath = $configResolver->getOption(OptionDefinition::RESOURCES_PATH);
        if (!is_dir($resourcesPath) || !is_readable($resourcesPath)) {
            $io->error(
                sprintf('Resources path specified "%s" does not exists or is not readable.', $resourcesPath)
            );
            return self::FAILURE;
        }

        $buildVersion = strtolower($configResolver->getOption(OptionDefinition::BUILD_VERSION));

        $dockerfilePath = $configResolver->getOption(OptionDefinition::DOCKERFILE_PATH);

        // checks Dockerfile template
        if (!is_file($dockerfilePath) || !is_readable($dockerfilePath)) {
            $io->error(
                sprintf('Dockerfile template specified "%s" does not exists or is not readable.', $dockerfilePath)
            );
            return self::FAILURE;
        }

        // checks Dockerfile specialized version
        $generatedDockerfilePath = $dockerfilePath . '.' . $buildVersion;
        if (is_file($generatedDockerfilePath)) {
            $io->warning(
                sprintf('Dockerfile build version "%s" already exists.', $generatedDockerfilePath)
            );
            return self::FAILURE;
        }

        $tools = (new Tools())->load($resourcesPath);

        $suffix = basename(dirname($dockerfilePath));

        switch ($suffix) {
            case 'mods':
                $dockerfile = $this->getChangeOnModsDockerfile($dockerfilePath, $tools, $phpVersion, $buildVersion);
                break;
            case 'work':
                $targetDir = $configResolver->getOption(OptionDefinition::TARGET_DIR);
                $tags = $configResolver->getOption(OptionDefinition::TAGS);
                $dockerfile = $this->getChangeOnWorkDockerfile($dockerfilePath, $tools, $phpVersion, $targetDir, $tags);
                break;
            case 'base':
            case 'prod':
                $dockerfile = file_get_contents($dockerfilePath);
                break;
            default:
                $dockerfile = null;
        }

        if ($dockerfile) {
            file_put_contents($generatedDockerfilePath, $dockerfile);
            $io->success(
                sprintf(
                    'The Dockerfile build version "%s" was generated with latest resources found in "%s"',
                    $generatedDockerfilePath,
                    $resourcesPath
                )
            );
        } else {
            $io->caution(sprintf('The Dockerfile build version "%s" was not modified', $generatedDockerfilePath));
        }

        return self::SUCCESS;
    }

    /**
     * @throws Exception
     */
    private function getChangeOnModsDockerfile(string $dockerfilePath, ToolCollectionInterface $tools, string $phpVersion, string $buildVersion): ?string
    {
        $tools->sortByName();

        $extensionsList = $tools->filter(function (Tool $tool) use ($phpVersion) {
            return
                in_array('pecl-extensions', $tool->getTags(), true) &&
                !in_array('exclude-php:' . $phpVersion, $tool->getTags(), true)
                ;
        });

        $modulesInstallation = ['FROM builder as build-version-' . $buildVersion];
        foreach ($extensionsList as $extension) {
            $command = $extension->getCommand();
            $modulesInstallation[] = (string) $command;
        }
        $modulesInstallation = implode(PHP_EOL, $modulesInstallation);

        $dockerfile = file_get_contents($dockerfilePath);

        return preg_replace(
            '/(FROM builder as build-version-1\n\n)(.*?)/smi',
            '$1' . $modulesInstallation . PHP_EOL . '$2',
            $dockerfile
        );
    }

    /**
     * @param string $dockerfilePath
     * @param ToolCollectionInterface $tools
     * @param string $phpVersion
     * @param string $targetDir
     * @param string[] $tags
     * @return string|null
     */
    private function getChangeOnWorkDockerfile(string $dockerfilePath, ToolCollectionInterface $tools, string $phpVersion, string $targetDir, array $tags): ?string
    {
        $tools->sortByPriority();

        $toolsList = $tools->filter(function (Tool $tool) use ($phpVersion, $tags) {
            $preFilter =
                !in_array('pecl-extensions', $tool->getTags(), true) &&
                !in_array('exclude-php:' . $phpVersion, $tool->getTags(), true)
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

        $softwareInstallation = [];
        foreach ($toolsList as $tool) {
            $command = $tool->getCommand();
            $commandLine = (string) $command;
            $os = php_uname('s');
            $arch = php_uname('m');
            $os = strtolower($os);
            $arch = str_contains($arch, 'x86') ? '386' : $arch;
            $commandLine = str_replace(['%os%', '%arch%'], [$os, $arch], $commandLine);
            $commandLine = str_replace('%target-dir%', $targetDir, $commandLine);
            $softwareInstallation[] = 'RUN set -eux && ' . $commandLine;
        }
        $softwareInstallation = implode(PHP_EOL, $softwareInstallation);
        $softwareInstallation = str_replace(' && ', ' \\' . PHP_EOL . '    && ', $softwareInstallation);

        $dockerfile = file_get_contents($dockerfilePath);

        return preg_replace(
            '/(### Install custom software\n###\n\n)(.*?)/smi',
            '$1' . $softwareInstallation  . PHP_EOL . '$2',
            $dockerfile
        );
    }
}
