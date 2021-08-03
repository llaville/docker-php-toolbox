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
| amqp | [The amqp PHP Extension](https://pecl.php.net/package/amqp) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| apcu | [The apcu PHP Extension](https://pecl.php.net/package/APCu) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| ast | [The ast PHP Extension](https://pecl.php.net/package/ast) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| geoip | [The geoip PHP Extension](https://pecl.php.net/package/geoip) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| http | [The http PHP Extension](https://pecl.php.net/package/pecl_http) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| igbinary | [The igbinary PHP Extension](https://pecl.php.net/package/igbinary) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| imagick | [The imagick PHP Extension](https://pecl.php.net/package/imagick) | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| jsmin | [The jsmin PHP Extension](https://pecl.php.net/package/jsmin) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| lzf | [The lzf PHP Extension](https://pecl.php.net/package/lzf) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| mailparse | [The mailparse PHP Extension](https://pecl.php.net/package/mailparse) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| mcrypt | [The mcrypt PHP Extension](https://pecl.php.net/package/mcrypt) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| memcache | [The memcache PHP Extension](https://pecl.php.net/package/memcache) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| memcached | [The memcached PHP Extension](https://pecl.php.net/package/memcached) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| mongo | [The mongo PHP Extension](https://pecl.php.net/package/mongo) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; |
| mongodb | [The mongodb PHP Extension](https://pecl.php.net/package/mongodb) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| msgpack | [The msgpack PHP Extension](https://pecl.php.net/package/msgpack) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| oauth | [The oauth PHP Extension](https://pecl.php.net/package/oauth) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| raphf | [The raphf PHP Extension](https://pecl.php.net/package/raphf) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| rdkafka | [The rdkafka PHP Extension](https://pecl.php.net/package/rdkafka) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| recode | [The recode PHP Extension](https://pecl.php.net/package/recode) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; |
| redis | [The redis PHP Extension](https://pecl.php.net/package/redis) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| solr | [The solr PHP Extension](https://pecl.php.net/package/solr) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| ssh2 | [The ssh2 PHP Extension](https://pecl.php.net/package/ssh2) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| stomp | [The stomp PHP Extension](https://pecl.php.net/package/stomp) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| uploadprogress | [The uploadprogress PHP Extension](https://pecl.php.net/package/uploadprogress) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; |
| uuid | [The uuid PHP Extension](https://pecl.php.net/package/uuid) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| vips | [The vips PHP Extension](https://pecl.php.net/package/vips) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| wddx | [The wddx PHP Extension](https://pecl.php.net/package/wddx) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; |
| xdebug | [The xdebug PHP Extension](https://pecl.php.net/package/xdebug) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| xhprof | [The xhprof PHP Extension](https://pecl.php.net/package/xhprof) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| xlswriter | [The xlswriter PHP Extension](https://pecl.php.net/package/xlswriter) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x274C; |
| xmldiff | [The xmldiff PHP Extension](https://pecl.php.net/package/xmldiff) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| xmlrpc | [The xmlrpc PHP Extension](https://pecl.php.net/package/xmlrpc) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| yaml | [The yaml PHP Extension](https://pecl.php.net/package/yaml) | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
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
| phpunit 7 | [The PHP Unit Testing framework (7.x version)](https://github.com/sebastianbergmann/phpunit) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x274C; | &#x274C; | &#x274C; |
| phpunit 8 | [The PHP Unit Testing framework (8.x version)](https://github.com/sebastianbergmann/phpunit) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| phpunit 9 | [The PHP Unit Testing framework (9.x version)](https://github.com/sebastianbergmann/phpunit) | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x274C; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| pickle | [PHP Extension installer](https://github.com/FriendsOfPHP/pickle) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |
| tig | [Text-mode interface for git](https://github.com/jonas/tig) | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; | &#x2705; |

## Credits

Thanks to jakzal PHP [Toolbox](https://github.com/jakzal/toolbox/) project that help me to build this architecture.
