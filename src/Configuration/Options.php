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
interface Options
{
    /**
     * @return array{
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
     * }
     */
    public function resolve(): array;
}
