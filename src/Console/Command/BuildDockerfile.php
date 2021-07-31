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

use function file_get_contents;
use function file_put_contents;
use function in_array;
use function is_dir;
use function is_file;
use function is_readable;
use function preg_replace;
use function sprintf;
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
                'tools',
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

        $dockerfilePath = $input->getOption('dockerfile');
        if (!is_file($dockerfilePath) || !is_readable($dockerfilePath)) {
            $io->error(
                sprintf('Dockerfile specified "%s" does not exists or is not readable.', $dockerfilePath)
            );
            return self::FAILURE;
        }

        $suffix = basename(dirname($dockerfilePath));
        if ('mods' !== $suffix) {
            $io->warning('Only mods Dockerfile could be rebuild with this command.');
            return self::SUCCESS;
        }

        $tools = (new Tools())->load($toolsPath);

        $extensionsList = $tools->filter(function(Tool $tool) use($phpVersion) {
            return
                in_array('pecl-extensions', $tool->getTags(), true) &&
                !in_array('exclude-php:'.$phpVersion, $tool->getTags(), true)
            ;
        });

        $modulesInstallation = 'FROM builder as build-version-' . $input->getOption('build-version') . PHP_EOL;
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

        $io->success(
            sprintf(
                'The Dockerfile specified %s was updated with latest PHP modules found in %s',
                $dockerfilePath,
                $toolsPath
            )
        );

        return self::SUCCESS;
    }
}
