<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Console\Command;

use Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

use LogicException;
use function basename;
use function dirname;
use function file_get_contents;
use function implode;
use function preg_match_all;
use function sprintf;
use function strtolower;

/**
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class BuildImage extends Command implements CommandInterface
{
    public const NAME = 'build:image';

    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this->setName(self::NAME)
            ->setDescription('Build an image from a Dockerfile by specified version')
            ->addArgument(
                'version',
                InputArgument::REQUIRED,
                'PHP version. Should be either 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 or 8.1'
            )
            ->addOption(
                'dockerfile',
                'f',
                InputOption::VALUE_REQUIRED,
                'Path to the Dockerfile template',
                './Dockerfiles/mods/Dockerfile'
            )
            ->addOption(
                'build-version',
                'B',
                InputOption::VALUE_REQUIRED,
                'Build version to identify the final Dockerfile from template (case insensitive)',
                '1'
            )
            ->addOption(
                'no-cache',
                null,
                InputOption::VALUE_NONE,
                'Do not use cache when building the image'
            )
            ->addOption(
                'vendor',
                null,
                InputOption::VALUE_REQUIRED,
                'Vendor name to prefix Docker images',
                'local'
            )
            ->addOption(
                'profile',
                null,
                InputOption::VALUE_NONE,
                'Display timing and memory usage information'
            )
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $executableFinder = new ExecutableFinder();
        $dockerBin = $executableFinder->find('docker', 'docker');
        if (null === $dockerBin) {
            $io->error('Please install Docker 19.03 or greater, before to continue ...');
            return self::FAILURE;
        }

        $phpVersion = $input->getArgument('version');
        if (!in_array($phpVersion, ['5.6', '7.0', '7.1', '7.2', '7.3', '7.4', '8.0', '8.1'])) {
            $io->error(
                sprintf('PHP version specified "%s" is not allowed.', $phpVersion)
            );
            return self::FAILURE;
        }

        $dockerfilePath = $input->getOption('dockerfile');

        $buildVersion = strtolower($input->getOption('build-version'));

        // checks Dockerfile specialized version
        $dockerfilePath .= '.' . $buildVersion;
        if (!is_file($dockerfilePath) || !is_readable($dockerfilePath)) {
            $io->error(
                sprintf('Dockerfile build version "%s" does not exists or is not readable.', $dockerfilePath)
            );
            return self::FAILURE;
        }

        $noCache = $input->getOption('no-cache');

        $suffix = basename(dirname($dockerfilePath));

        if ('mods' === $suffix) {
            $result = preg_match_all('/FROM builder as build-version-(.*)/', file_get_contents($dockerfilePath), $matches);
            if (0 == $result) {
                $io->error('Your Dockerfile is invalid. Please build a fresh copy with `build:dockerfile` command');
                return self::FAILURE;
            }

            if (!in_array($buildVersion, $matches[1])) {
                $io->error(
                    sprintf(
                        'Your Dockerfile defines only build (%s), and you request build version %d',
                        implode(', ', $matches[1]),
                        $buildVersion
                    )
                );
                return self::FAILURE;
            }
        }

        $vendor = $input->getOption('vendor');
        $commonTag = $vendor . '/php-fpm:' . $phpVersion;

        if ('base' === $suffix) {
            $tag = $commonTag . '-base';

            $command = [
                $dockerBin, 'build',
                '--tag=' . $tag,
                '--file=' . $dockerfilePath,
                '--build-arg=PHP_VERSION=' . $phpVersion,
            ];
        } elseif ('mods' === $suffix) {
            $tag = $commonTag . '-mods';

            $command = [
                $dockerBin, 'build',
                '--target=after-condition',
                '--tag=' . $tag,
                '--file=' . $dockerfilePath,
                '--build-arg=PHP_VERSION=' . $phpVersion,
                '--build-arg=BUILD_VERSION=' . $buildVersion,
                '--build-arg=VENDOR=' . $vendor,
            ];
        } elseif ('prod' === $suffix) {
            $tag = $commonTag . '-prod';

            $command = [
                $dockerBin, 'build',
                '--tag=' . $tag,
                '--file=' . $dockerfilePath,
                '--build-arg=PHP_VERSION=' . $phpVersion,
                '--build-arg=VENDOR=' . $vendor,
            ];
            if (!$noCache) {
                $command[] = '--cache-from=' . $commonTag . '-mods';
            }
        } elseif ('work' === $suffix) {
            $tag = $commonTag . '-work';

            $command = [
                $dockerBin, 'build',
                '--tag=' . $tag,
                '--file=' . $dockerfilePath,
                '--build-arg=PHP_VERSION=' . $phpVersion,
                '--build-arg=VENDOR=' . $vendor,
            ];
            if (!$noCache) {
                $command[] = '--cache-from=' . $commonTag . '-prod';
            }
        } else {
            throw new LogicException(
                sprintf('Invalid Dockerfile sub-folder "%s" found.', $suffix)
            );
        }

        if ($noCache) {
            $command[] = '--no-cache';
        } else {
            $command[] = '--build-arg=BUILDKIT_INLINE_CACHE=1';
            $command[] = '--cache-from=' . $tag;
        }
        $command[] = './' . dirname($dockerfilePath);

        $process = new Process($command, null, ['DOCKER_BUILDKIT' => '1']);
        $process->setTimeout(60 * 60);
        $status = $this->runProcess($process, $io);

        if (self::SUCCESS === $status) {
            $io->success(
                sprintf(
                    'The %s tagged image was built with Dockerfile found in %s',
                    $tag,
                    $dockerfilePath
                )
            );
        } elseif (self::FAILURE === $status) {
            $io->writeln($process->getErrorOutput());
            $io->error(
                sprintf(
                    'The %s image had an error when building with the Dockerfile found in %s',
                    $tag,
                    $dockerfilePath
                )
            );
        }

        return $status;
    }

    /**
     * @param Process $process
     * @param SymfonyStyle $io
     * @return int
     */
    private function runProcess(Process $process, SymfonyStyle $io): int
    {
        $command = $process->getCommandLine();
        $io->comment(sprintf('<info>[RUN]</info> %s', $command));

        $process->start();

        if ($io->isDebug()) {
            $process->wait(function ($type, $buffer) {
                echo $buffer;
            });
        } else {
            $process->wait();
        }

        if ($process->isSuccessful()) {
            return self::SUCCESS;
        }

        return self::FAILURE;
    }
}
