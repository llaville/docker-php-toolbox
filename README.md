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

## PHP-FPM Flavours

Architecture is Devilbox compatible, but may be used for other Docker containers solution.

#### Assembly

The provided Docker images heavily rely on inheritance to guarantee is the smallest possible image size.
Each of them provide a working PHP-FPM server, so you must decide what version works best for you.
Look at the sketch below to get an overview about the two provided flavours and each of their different types.

```shell
        [PHP]            # Base FROM image (Official PHP-FPM image)
          ^              #
          |              #
          |              #
        [base]           # Introduces env variables and adjusts entrypoint
          ^              #
          |              #
          |              #
        [mods]           # Installs additional PHP modules
          ^              # via pecl, git and other means
          |              #
          |              #
        [prod]           # Devilbox flavour for production
          ^              # (locales, postfix, socat and injectables)
          |              # (custom modules and *.ini files)
          |              #
        [work]           # Devilbox flavour for local development
                         # (includes backup and development tools)
                         # (sudo, custom bash and tool configs)
```

## Requirements

* PHP 7.3 or greater
* ext-json

## Installation

The recommended way to install this project is [through composer](http://getcomposer.org).
If you don't know yet what is composer, have a look [on introduction](http://getcomposer.org/doc/00-intro.md).

```shell
$ composer require bartlett/docker-php-toolbox
```

## Usage

In each following commands, replace `<php_version>` by either 5.2, 5.3, 5.4, 5.5, 5.6, 7.0, 7.1, 7.2, 7.3, 7.4, 8.0 or 8.1

### Build Dockerfiles

For all builds we suggest passing the `--build-version` (`-B`) option to choose suffix of your generated Dockerfile.

**TIP** Even if argument is free, we suggest using a build version that allow to identify quickly
contents of Dockerfile generated.

#### Base images

```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/base/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/base/Dockerfile -B 7422 7.4
```
Or with specialized dockerfile:
```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/base/Dockerfile-81 -B 8100 8.1
```

#### Mods images

```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/mods/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/mods/Dockerfile -B 8009 8.0
```

#### Prod images

```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/prod/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/prod/Dockerfile -B 8100 8.1
```

#### Work images

By default, tools are installed in the `/usr/local/bin` directory.
To perform installation in another location, pass the `--target-dir` option.

To limit some tools to the generated Dockerfile, multiple `--tag` options can be passed.

```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/work/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:dockerfile -f ./Dockerfiles/work/Dockerfile -B 7329 --target-dir /usr/bin --tag composer --tag tig 7.3
```

### Build Images

Proceed with the same build identification as used in the `build:dockerfile` command, passing the `--build-version` (`-B`) option.

**NOTE** If you want to see real-time docker long process running, don't forget to activate verbose level 3 (`-vvv`) on each command.

#### Base images

```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile -B 7422 -vvv 7.4
```
Or with specialized dockerfile:
```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/base/Dockerfile-81 -B 8100 -vvv 8.1
```

#### Mods images

```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/mods/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/mods/Dockerfile -B 8009 8.0
```

#### Prod images

```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/prod/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/prod/Dockerfile -B 8100 8.1
```

#### Work images

```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/work/Dockerfile -B <build_version> <php_version>
```
For example:
```shell
$ bin/toolkit.php build:image -f ./Dockerfiles/work/Dockerfile -B 7329 -vvv 7.3
```

### List available extensions

```shell
$ bin/tookit.php list:extensions <php_version>
```
To get list of compatible extensions for a PHP platform.
For example:
```shell
$ bin/tookit.php list:extensions 8.1

List available extensions for PHP 8.1
=====================================

 ----------- ----------------------------- ----------------------------------------
  Name        Description                   Website
 ----------- ----------------------------- ----------------------------------------
  amqp        The amqp PHP Extension        https://pecl.php.net/package/amqp
  apcu        The apcu PHP Extension        https://pecl.php.net/package/APCu
  ast         The ast PHP Extension         https://pecl.php.net/package/ast
  http        The http PHP Extension        https://pecl.php.net/package/pecl_http
  igbinary    The igbinary PHP Extension    https://pecl.php.net/package/igbinary
  imagick     The imagick PHP Extension     https://pecl.php.net/package/imagick
  lzf         The lzf PHP Extension         https://pecl.php.net/package/lzf
  mcrypt      The mcrypt PHP Extension      https://pecl.php.net/package/mcrypt
  memcache    The memcache PHP Extension    https://pecl.php.net/package/memcache
  memcached   The memcached PHP Extension   https://pecl.php.net/package/memcached
  msgpack     The msgpack PHP Extension     https://pecl.php.net/package/msgpack
  oauth       The oauth PHP Extension       https://pecl.php.net/package/oauth
  raphf       The raphf PHP Extension       https://pecl.php.net/package/raphf
  redis       The redis PHP Extension       https://pecl.php.net/package/redis
  solr        The solr PHP Extension        https://pecl.php.net/package/solr
  ssh2        The ssh2 PHP Extension        https://pecl.php.net/package/ssh2
  uuid        The uuid PHP Extension        https://pecl.php.net/package/uuid
  vips        The vips PHP Extension        https://pecl.php.net/package/vips
  xdebug      The xdebug PHP Extension      https://pecl.php.net/package/xdebug
  xhprof      The xhprof PHP Extension      https://pecl.php.net/package/xhprof
  xmldiff     The xmldiff PHP Extension     https://pecl.php.net/package/xmldiff
  zip         The zip PHP Extension         https://pecl.php.net/package/zip
 ----------- ----------------------------- ----------------------------------------

 ! [NOTE] 22 extensions available. The pre-installed PHP extensions are excluded from this list.
 ```

### List available extensions

```shell
$ bin/tookit.php list:tools <php_version>
```
To get list of compatible tools for a PHP platform.

#### Filter tools by tags

To limit some tools from the listing, multiple `--tag` options can be added.
For example:
```shell
$ bin/tookit.php list:tools 7.4 --tag composer --tag phpunit

List available tools for PHP 7.4
================================

 ----------- ---------------------------------------------- ----------------------------------------------
  Name        Description                                    Website
 ----------- ---------------------------------------------- ----------------------------------------------
  composer    Dependency Manager for PHP                     https://github.com/composer/composer
  phpunit 8   The PHP Unit Testing framework (8.x version)   https://github.com/sebastianbergmann/phpunit
  phpunit 9   The PHP Unit Testing framework (9.x version)   https://github.com/sebastianbergmann/phpunit
 ----------- ---------------------------------------------- ----------------------------------------------

 ! [NOTE] 3 tools available.
```

## Examples

Want to learn more, around real examples.
Please have a look on [UseCases](https://github.com/llaville/docker-php-toolbox/tree/master/UseCases) directory.

## Available extensions

| Name | Description | <sup>PHP 5.2</sup> | <sup>PHP 5.3</sup> | <sup>PHP 5.4</sup> | <sup>PHP 5.5</sup> | <sup>PHP 5.6</sup> | <sup>PHP 7.0</sup> | <sup>PHP 7.1</sup> | <sup>PHP 7.2</sup> | <sup>PHP 7.3</sup> | <sup>PHP 7.4</sup> | <sup>PHP 8.0</sup> | <sup>PHP 8.1</sup> |
| :--- | :---------- | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ |
| amqp | [The amqp PHP Extension](https://pecl.php.net/package/amqp) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| apcu | [The apcu PHP Extension](https://pecl.php.net/package/APCu) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| ast | [The ast PHP Extension](https://pecl.php.net/package/ast) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| bcmath | [The bcmath PHP Extension](https://github.com/php/php-src/tree/master/ext/bcmath) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| bz2 | [The bz2 PHP Extension](https://github.com/php/php-src/tree/master/ext/bz2) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| calendar | [The calendar PHP Extension](https://github.com/php/php-src/tree/master/ext/calendar) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| dba | [The dba PHP Extension](https://github.com/php/php-src/tree/master/ext/dba) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| enchant | [The enchant PHP Extension](https://github.com/php/php-src/tree/master/ext/enchant) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| exif | [The exif PHP Extension](https://github.com/php/php-src/tree/master/ext/exif) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| gd | [The gd PHP Extension](https://github.com/php/php-src/tree/master/ext/gd) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| geoip | [The geoip PHP Extension](https://pecl.php.net/package/geoip) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| gettext | [The gettext PHP Extension](https://github.com/php/php-src/tree/master/ext/gettext) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| gmp | [The gmp PHP Extension](https://github.com/php/php-src/tree/master/ext/gmp) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| http | [The http PHP Extension](https://pecl.php.net/package/pecl_http) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| igbinary | [The igbinary PHP Extension](https://pecl.php.net/package/igbinary) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| imagick | [The imagick PHP Extension](https://pecl.php.net/package/imagick) | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| imap | [The imap PHP Extension](https://github.com/php/php-src/tree/master/ext/imap) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| interbase | [The interbase PHP Extension](https://github.com/php/php-src/tree/PHP-7.3/ext/interbase) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; |
| intl | [The intl PHP Extension](https://github.com/php/php-src/tree/master/ext/intl) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| ioncube | [Loader for ionCube Secured Files](https://www.ioncube.com/loaders.php) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| jsmin | [The jsmin PHP Extension](https://pecl.php.net/package/jsmin) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| ldap | [The ldap PHP Extension](https://github.com/php/php-src/tree/master/ext/ldap) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| lzf | [The lzf PHP Extension](https://pecl.php.net/package/lzf) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| mailparse | [The mailparse PHP Extension](https://pecl.php.net/package/mailparse) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| mcrypt | [The mcrypt PHP Extension](https://pecl.php.net/package/mcrypt) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| memcache | [The memcache PHP Extension](https://pecl.php.net/package/memcache) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| memcached | [The memcached PHP Extension](https://pecl.php.net/package/memcached) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| mongo | [The mongo PHP Extension](https://pecl.php.net/package/mongo) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; |
| mongodb | [The mongodb PHP Extension](https://pecl.php.net/package/mongodb) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| msgpack | [The msgpack PHP Extension](https://pecl.php.net/package/msgpack) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| mysql | [The mysql PHP Extension](https://pecl.php.net/package/mysql) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; |
| mysqli | [The mysqli PHP Extension](https://github.com/php/php-src/tree/master/ext/mysqli) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| oauth | [The oauth PHP Extension](https://pecl.php.net/package/oauth) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| oci8 | [The oci8 PHP Extension](https://pecl.php.net/package/oci8) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| opcache | [The opcache PHP Extension](https://github.com/php/php-src/tree/master/Zend) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pcntl | [The pcntl PHP Extension](https://github.com/php/php-src/tree/master/ext/pcntl) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pdo_dblib | [The pdo_dblib PHP Extension](https://github.com/php/php-src/tree/master/ext/pdo_dblib) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| pdo_firebird | [The pdo_firebird PHP Extension](https://github.com/php/php-src/tree/master/ext/pdo_firebird) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pdo_mysql | [The pdo_mysql PHP Extension](https://github.com/php/php-src/tree/master/ext/pdo_mysql) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pdo_oci | [The pdo_oci PHP Extension](https://github.com/php/php-src/tree/master/ext/pdo_oci) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| raphf | [The raphf PHP Extension](https://pecl.php.net/package/raphf) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| rdkafka | [The rdkafka PHP Extension](https://pecl.php.net/package/rdkafka) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| recode | [The recode PHP Extension](https://pecl.php.net/package/recode) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; |
| redis | [The redis PHP Extension](https://pecl.php.net/package/redis) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| solr | [The solr PHP Extension](https://pecl.php.net/package/solr) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| ssh2 | [The ssh2 PHP Extension](https://pecl.php.net/package/ssh2) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| stomp | [The stomp PHP Extension](https://pecl.php.net/package/stomp) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| uopz | [The uopz PHP Extension](https://pecl.php.net/package/uopz) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| uploadprogress | [The uploadprogress PHP Extension](https://pecl.php.net/package/uploadprogress) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| uuid | [The uuid PHP Extension](https://pecl.php.net/package/uuid) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| vips | [The vips PHP Extension](https://pecl.php.net/package/vips) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| wddx | [The wddx PHP Extension](https://pecl.php.net/package/wddx) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; |
| xdebug | [The xdebug PHP Extension](https://pecl.php.net/package/xdebug) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| xhprof | [The xhprof PHP Extension](https://pecl.php.net/package/xhprof) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| xlswriter | [The xlswriter PHP Extension](https://pecl.php.net/package/xlswriter) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| xmldiff | [The xmldiff PHP Extension](https://pecl.php.net/package/xmldiff) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| xmlrpc | [The xmlrpc PHP Extension](https://pecl.php.net/package/xmlrpc) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| yaml | [The yaml PHP Extension](https://pecl.php.net/package/yaml) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| zip | [The zip PHP Extension](https://pecl.php.net/package/zip) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |

## Available tools

| Name | Description | <sup>PHP 5.2</sup> | <sup>PHP 5.3</sup> | <sup>PHP 5.4</sup> | <sup>PHP 5.5</sup> | <sup>PHP 5.6</sup> | <sup>PHP 7.0</sup> | <sup>PHP 7.1</sup> | <sup>PHP 7.2</sup> | <sup>PHP 7.3</sup> | <sup>PHP 7.4</sup> | <sup>PHP 8.0</sup> | <sup>PHP 8.1</sup> |
| :--- | :---------- | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ | :------ |
| box | [Fast, zero config application bundler with PHARs](https://github.com/box-project/box) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| composer | [Dependency Manager for PHP](https://github.com/composer/composer) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| graphviz | [Graph Visualization Tools](https://graphviz.org/) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| htop | [Interactive process viewer](https://github.com/htop-dev/htop) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| jq | [Command-line JSON processor](https://github.com/stedolan/jq) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| mhsendmail | [sendmail for MailHog](https://github.com/BlueBambooStudios/mhsendmail) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| phplint v2 | [Checks PHP file syntax](https://github.com/overtrue/phplint) | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| phplint v3 | [Checks PHP file syntax](https://github.com/overtrue/phplint) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; |
| phpunit 7 | [The PHP Unit Testing framework (7.x version)](https://github.com/sebastianbergmann/phpunit) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; |
| phpunit 8 | [The PHP Unit Testing framework (8.x version)](https://github.com/sebastianbergmann/phpunit) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| phpunit 9 | [The PHP Unit Testing framework (9.x version)](https://github.com/sebastianbergmann/phpunit) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pickle | [PHP Extension installer](https://github.com/FriendsOfPHP/pickle) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pip v2 | [The Python package installer (2.x version)](https://github.com/pypa/pip) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pip v3 | [The Python package installer (3.x version)](https://github.com/pypa/pip) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| tig | [Text-mode interface for git](https://github.com/jonas/tig) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| yq | [Command-line YAML processor](https://github.com/mikefarah/yq) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |

## Contributing

This project is still a young project with a long roadmap of features to come (see ROADMAP.md file),
if we want a real compatible [Devilbox](https://github.com/cytopia/devilbox) alternative.

Please consider it as a running prototype rather than a full filled application.

Any kind of contribution is welcome.

Visit the forums
* for [announcements](https://github.com/llaville/docker-php-toolbox/discussions/categories/announcements) of new versions
* if you want to [ask a question or help others](https://github.com/llaville/docker-php-toolbox/discussions/categories/q-a)
* [learn](https://github.com/llaville/docker-php-toolbox/discussions/categories/show-and-tell) more about any features
* suggest new [ideas](https://github.com/llaville/docker-php-toolbox/discussions/categories/ideas)
* or any [other stuffs](https://github.com/llaville/docker-php-toolbox/discussions/categories/general)

## Credits

Thanks to :
* cytopia for its Devilbox's [PHP-FPM Docker](https://github.com/devilbox/docker-php-fpm) Images
* jakzal PHP [Toolbox](https://github.com/jakzal/toolbox/) project that help me to build this architecture.
