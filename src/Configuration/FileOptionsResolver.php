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
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

use function is_array;
use function sprintf;

/**
 * @author Laurent Laville
 * @since Release 2.0.0
 */
class FileOptionsResolver extends AbstractOptionsResolver
{
    public function __construct(InputInterface $input)
    {
        $configFile = $input->getOption(OptionDefinition::CONFIGURATION);

        try {
            $configuration = Yaml::parseFile($configFile);
        } catch (ParseException $e) {
            // If the file could not be read or the YAML is not valid
            $configuration = [];
        }

        if (null === $configuration) {
            // YAML file is empty (but may contain comments)
            $configuration = [];
        }

        if (!is_array($configuration)) {
            throw new InvalidOptionsException(sprintf('Invalid content type in "%s".', $configFile));
        }

        foreach ($configuration as $name => $value) {
            if (null === $value) {
                throw new InvalidOptionsException(sprintf('Invalid content type in "%s" for option "%s".', $configFile, $name));
            }
        }

        parent::__construct($input, $configuration);
    }

    public function factory(): Options
    {
        return new OptionsFactory($this->defaults);
    }
}
