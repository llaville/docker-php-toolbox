<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Configuration;

use Symfony\Component\OptionsResolver\Options as SymfonyOptions;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function array_keys;

/**
 * @author Laurent Laville
 * @since Release 2.0.0
 */
class OptionsFactory implements Options
{
    /**
     * @param array{
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
    public function __construct(private readonly array $defaults)
    {
    }

    public function resolve(): array
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $resolver->setDefaults($this->defaults);
        return $resolver->resolve();
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $definitions = [
            OptionDefinition::CONFIGURATION => 'string',
            OptionDefinition::NO_CONFIGURATION => 'bool',
            OptionDefinition::PHP_VERSION => ['string', 'float'],
            OptionDefinition::BUILD_VERSION => ['string', 'int'],
            OptionDefinition::RESOURCES_PATH => 'string',
            OptionDefinition::DOCKERFILE_PATH => 'string',
            OptionDefinition::TARGET_DIR => 'string',
            OptionDefinition::TAGS => 'string[]',
            OptionDefinition::NO_CACHE => 'bool',
            OptionDefinition::VENDOR_NAME => 'string',
            OptionDefinition::PROFILE => 'bool',
            OptionDefinition::WORK_TAG_SUFFIX => 'string',

            'ansi' => ['null', 'bool'],
            'help' => ['null', 'bool'],
            'no-interaction' => 'bool',
            'quiet' => ['null', 'bool'],
            'verbose' => ['null', 'bool'],
            'version' => ['null', 'bool'],
            'command' => ['null', 'string'],
        ];

        $resolver->setDefined(array_keys($definitions));

        foreach ($definitions as $option => $allowedTypes) {
            $resolver->setAllowedTypes($option, $allowedTypes);
        }

        $resolver->setNormalizer(OptionDefinition::PHP_VERSION, function (SymfonyOptions $options, $value) {
            return (string) $value;
        });
        $resolver->setNormalizer(OptionDefinition::BUILD_VERSION, function (SymfonyOptions $options, $value) {
            return (string) $value;
        });
    }
}
