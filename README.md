<!-- markdownlint-disable MD013 -->
# Docker PHP Toolbox

| Stable |
|:------:|
| [![Latest Stable Version](https://img.shields.io/packagist/v/bartlett/docker-php-toolbox)](https://packagist.org/packages/bartlett/docker-php-toolbox) |
| [![Minimum PHP Version](https://img.shields.io/packagist/php-v/bartlett/docker-php-toolbox/dev-master)](https://www.php.net/supported-versions.php) |
| [![License](https://img.shields.io/github/license/llaville/docker-php-toolbox)](https://github.com/llaville/docker-php-toolbox/blob/master/LICENSE) |
| [![GitHub Discussions](https://img.shields.io/github/discussions/llaville/docker-php-toolbox)](https://github.com/llaville/docker-php-toolbox/discussions) |
| [![Mega-Linter](https://github.com/llaville/docker-php-toolbox/actions/workflows/mega-linter.yml/badge.svg)](https://github.com/llaville/docker-php-toolbox/actions/workflows/mega-linter.yml) |
| [![GitHub-Pages](https://github.com/llaville/docker-php-toolbox/actions/workflows/gh-pages.yml/badge.svg)](https://github.com/llaville/docker-php-toolbox/actions/workflows/gh-pages.yml) |

Easily install PHP extensions and tools in Docker containers.

## Documentation

All the documentation is available on [website](https://llaville.github.io/docker-php-toolbox/1.x/),
generated from the [docs](https://github.com/llaville/docker-php-toolbox/tree/master/docs) folder.

- [Getting Started](https://llaville.github.io/docker-php-toolbox/1.x/getting-started/).

## About experimental support to PHP 8.2

Uses the `Dockerfiles/base/Dockerfile-82` template for which no official versions exist yet.

Actually based on `devilbox/php-fpm-8.2:latest` instead of `php:8.2-fpm-buster`

**CAUTION** if you used `devilbox/php-fpm-8.2:latest`. Please read issue report https://github.com/devilbox/docker-php-fpm-8.2/issues/11

