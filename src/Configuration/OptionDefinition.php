<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Configuration;

/**
 * @author Laurent Laville
 * @since Release 2.0.0
 */
interface OptionDefinition
{
    public const CONFIGURATION = 'configuration';
    public const NO_CONFIGURATION = 'no-configuration';
    public const PHP_VERSION = 'php-version';
    public const BUILD_VERSION = 'build-version';
    public const RESOURCES_PATH = 'resources';
    public const DOCKERFILE_PATH = 'dockerfile';
    public const TARGET_DIR = 'target-dir';
    public const TAGS = 'tags';
    public const NO_CACHE = 'no-cache';
    public const VENDOR_NAME = 'vendor';
    public const PROFILE = 'profile';
    public const WORK_TAG_SUFFIX = 'work-tag-suffix';
    public const DEFAULT_CONFIG_FILE = '.docker-php-toolbox.yml';
    public const DEFAULT_PHP_VERSION = '8.2';
    public const DEFAULT_BUILD_VERSION = '8200';
    public const DEFAULT_RESOURCES_PATH = './resources';
    public const DEFAULT_DOCKERFILE_PATH = './Dockerfiles/base/Dockerfile';
    public const DEFAULT_TARGET_DIR = '/usr/local/bin';
    public const DEFAULT_VENDOR_NAME = 'local';
    public const DEFAULT_WORK_TAG_SUFFIX = 'work';
}
