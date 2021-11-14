<!-- markdownlint-disable MD013 -->
# PHP-FPM

## Docker images

This repository contains a PHP CLI (Symfony Console) Application that can be used to easily install PHP extensions and tools
inside the [official PHP Docker images](https://hub.docker.com/_/php/).

This repository will provide you fully functional PHP-FPM Docker images in different flavors,
versions and packed with different types of integrated PHP modules.

## Flavors

Architecture is [Devilbox](https://github.com/cytopia/devilbox/) compatible, but may be used for other Docker containers solution.

### Assembly

The provided Docker images heavily rely on inheritance to guarantee is the smallest possible image size.
Each of them provide a working PHP-FPM server, so you must decide what version works best for you.
Look at the sketch below to get an overview about the two provided flavors and each of their different types.

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
        [prod]           # Devilbox flavor for production
          ^              # (locales, postfix, socat and injectables)
          |              # (custom modules and *.ini files)
          |              #
        [work]           # Devilbox flavor for local development
                         # (includes backup and development tools)
                         # (sudo, custom bash and tool configs)
```
