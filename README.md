# Docker PHP Toolbox

Easily install PHP extensions and tools in Docker containers.

Toolbox started its life as an alternative to [Devilbox's PHP-FPM Docker Images](https://github.com/devilbox/docker-php-fpm),
and its [Build Helper](https://github.com/devilbox/docker-php-fpm/tree/master/build) based around
the Red Hat [Ansible](https://www.ansible.com/) Automation Platform.

Its purpose is to install set of tools and PHP modules while building the docker image.

Its main goal is intended to be a very simple out-of-the-box solution, and allow more audience to use it and contribute.

Even if I started this project as an alternative to Docker PHP-FPM images of the [Devilbox project](https://github.com/cytopia/devilbox/)
(Docker LAMP stack), it could be used with other project that requires Docker PHP containers.

Its architecture require only [PHP](https://www.php.net/) and [JSON](https://www.json.org/) to define tools and php modules.

## PHP-FPM Docker images

This repository contains a PHP CLI (Symfony Console) Application that can be used to easily install PHP extensions and tools
inside the [official PHP Docker images](https://hub.docker.com/_/php/).

This repository will provide you fully functional PHP-FPM Docker images in different flavours,
versions and packed with different types of integrated PHP modules.

## Requirements

* PHP 7.3 or greater
* ext-json

## Installation

The recommended way to install this project is [through composer](http://getcomposer.org).
If you don't know yet what is composer, have a look [on introduction](http://getcomposer.org/doc/00-intro.md).

```bash
composer require bartlett/docker-php-toolbox
```
## Available extensions

| Name | Description | PHP 5.2 | PHP 5.3 | PHP 5.4 | PHP 5.5 | PHP 5.6 | PHP 7.0 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 | PHP 8.1 |
| :--- | :---------- | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ |

## Available tools

| Name | Description | PHP 5.2 | PHP 5.3 | PHP 5.4 | PHP 5.5 | PHP 5.6 | PHP 7.0 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 | PHP 8.1 |
| :--- | :---------- | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ |

## Credits

Thanks to jakzal PHP [Toolbox](https://github.com/jakzal/toolbox/) project that help me to build this architecture.
