<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Configuration;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

use function array_key_exists;
use function sprintf;

/**
 * @author Laurent Laville
 * @since Release 2.0.0
 */
abstract class AbstractOptionsResolver implements Resolver
{
    /**
     * @var array{
     *     configuration: string,
     *     no-configuration: bool,
     *     php-version: string,
     *     build-version: string,
     *     resources: string,
     *     dockerfile: string,
     *     target-dir: string,
     *     tags: string,
     *     no-cache: bool,
     *     vendor: string,
     *     profile: bool,
     *     work-tag-suffix: string
     * } $defaults
     */
    protected array $defaults;

    /**
     * @var array{
     *     configuration: string,
     *     no-configuration: bool,
     *     php-version: string,
     *     build-version: string,
     *     resources: string,
     *     dockerfile: string,
     *     target-dir: string,
     *     tags: string,
     *     no-cache: bool,
     *     vendor: string,
     *     profile: bool,
     *     work-tag-suffix: string
     * } $options
     */
    protected array $options;

    /**
     * @param array{
     *     php-version?: string,
     *     build-version?: string,
     *     resources?: string,
     *     dockerfile?: string,
     *     target-dir?: string,
     *     tags?: string,
     *     no-cache?: bool,
     *     vendor?: string,
     *     profile?: bool,
     *     work-tag-suffix?: string
     * } $configuration
     */
    public function __construct(InputInterface $input, array $configuration = [])
    {
        $arguments = $input->getArguments();
        $options = $input->getOptions();

        $optionDefaults = [
            OptionDefinition::CONFIGURATION => OptionDefinition::DEFAULT_CONFIG_FILE,
            OptionDefinition::NO_CONFIGURATION => false,
            OptionDefinition::PHP_VERSION => OptionDefinition::DEFAULT_PHP_VERSION,
            OptionDefinition::BUILD_VERSION => OptionDefinition::DEFAULT_BUILD_VERSION,
            OptionDefinition::RESOURCES_PATH => OptionDefinition::DEFAULT_RESOURCES_PATH,
            OptionDefinition::DOCKERFILE_PATH => OptionDefinition::DEFAULT_DOCKERFILE_PATH,
            OptionDefinition::TARGET_DIR => OptionDefinition::DEFAULT_TARGET_DIR,
            OptionDefinition::TAGS => [],
            OptionDefinition::NO_CACHE => false,
            OptionDefinition::VENDOR_NAME => OptionDefinition::DEFAULT_VENDOR_NAME,
            OptionDefinition::PROFILE => false,
            OptionDefinition::WORK_TAG_SUFFIX => OptionDefinition::DEFAULT_WORK_TAG_SUFFIX,
        ];

        $defaults = [];

        if (empty($arguments['version'])) {
            $defaults[OptionDefinition::PHP_VERSION] = $configuration[OptionDefinition::PHP_VERSION] ?? $optionDefaults[OptionDefinition::PHP_VERSION];
        } else {
            $defaults[OptionDefinition::PHP_VERSION] = $arguments['version'];
        }

        if (empty($options['no-cache'])) {
            unset($options['no-cache']);
        }
        if (empty($options['profile'])) {
            unset($options['profile']);
        }

        // options that cannot be overridden by YAML config file values
        $names = [
            OptionDefinition::CONFIGURATION,
            OptionDefinition::NO_CONFIGURATION
        ];
        foreach ($names as $name) {
            $defaults[$name] = $options[$name] ?? $optionDefaults[$name];
        }

        // all options that may be overridden by YAML config file values
        $names = [
            OptionDefinition::PHP_VERSION,
            OptionDefinition::BUILD_VERSION,
            OptionDefinition::RESOURCES_PATH,
            OptionDefinition::DOCKERFILE_PATH,
            OptionDefinition::TARGET_DIR,
            OptionDefinition::TAGS,
            OptionDefinition::NO_CACHE,
            OptionDefinition::VENDOR_NAME,
            OptionDefinition::PROFILE,
            OptionDefinition::WORK_TAG_SUFFIX,
        ];
        foreach ($names as $name) {
            $defaults[$name] = $options[$name] ?? $configuration[$name] ?? $optionDefaults[$name];
        }

        $this->defaults = $defaults;
    }

    abstract public function factory(): Options;

    public function getOptions(): array
    {
        $options = $this->factory();
        return $this->options = $options->resolve();
    }

    public function getOption(string $name): mixed
    {
        if (!isset($this->options)) {
            $this->getOptions();
        }

        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }

        throw new InvalidOptionsException(sprintf('The "%s" option does not exist.', $name));
    }
}
