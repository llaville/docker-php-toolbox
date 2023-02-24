<!-- markdownlint-disable MD013 MD024 MD033 -->
# About

Easily install PHP extensions and tools in Docker containers.

Toolbox started its life as an alternative to [Devilbox's PHP-FPM Docker Images](https://github.com/devilbox/docker-php-fpm),
and its [Build Helper](https://github.com/devilbox/docker-php-fpm/tree/master/build) based around
the Red Hat [Ansible](https://www.ansible.com/) Automation Platform.

Its purpose is to install set of tools and PHP modules while building the docker image.

Its main goal is intended to be a very simple out-of-the-box solution, and allow more audience to use it and contribute.

Even if I started this project as an alternative to Docker PHP-FPM images of the [Devilbox project](https://github.com/cytopia/devilbox/)
(Docker LAMP stack), it could be used with other project that requires Docker PHP containers.

Its architecture require only [PHP](https://www.php.net/) and [JSON](https://www.json.org/) to define tools and php modules.
