# syntax=docker/dockerfile:1
ARG PHP_VERSION=8.0
ARG BUILD_VERSION=1
ARG VENDOR=local

FROM ${VENDOR}/php-fpm:${PHP_VERSION}-base AS base

FROM base AS builder

### Add PHP 8.5 support since https://github.com/mlocati/docker-php-extension-installer/releases/tag/2.9.11
### Add support for oauth on PHP 8.5 since https://github.com/mlocati/docker-php-extension-installer/releases/tag/2.9.13
ARG DOCKER_PHP_EXTENSION_INSTALLER=2.9.13
ADD https://github.com/mlocati/docker-php-extension-installer/releases/download/${DOCKER_PHP_EXTENSION_INSTALLER}/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions

###
### Enable PHP modules which are not enabled by default
###
### "build-version-1" is restricted to pre-installed PHP extensions.
### You can list them with the following command: `docker run --rm php:8.0-fpm php -m`
### Change 8.0 to reflect the PHP version you are interested in.
### "build-version-X" where X is 2 or greater may be used for other preset modules installation.
###
FROM builder AS build-version-1


###
### Build final mods image
###
FROM build-version-${BUILD_VERSION} AS after-condition

FROM after-condition

###
### Copy artifacts from base
###
COPY --from=base /usr/local/etc/php/conf.d/xxx-devilbox-default-php.ini /usr/local/etc/php/conf.d/xxx-devilbox-default-php.ini
COPY --from=base /usr/local/etc/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY --from=base /docker-entrypoint.sh /docker-entrypoint.sh
COPY --from=base /docker-entrypoint.d /docker-entrypoint.d

###
### Labels
###
# https://github.com/opencontainers/image-spec/blob/main/annotations.md
LABEL "org.opencontainers.image.created"=""
LABEL "org.opencontainers.image.authors"="llaville"
LABEL "org.opencontainers.image.url"="https://github.com/llaville/docker-php-toolbox"
LABEL "org.opencontainers.image.documentation"="https://github.com/llaville/docker-php-toolbox"
LABEL "org.opencontainers.image.source"="https://github.com/llaville/docker-php-toolbox"
LABEL "org.opencontainers.image.version"=""
LABEL "org.opencontainers.image.revision"=""
LABEL "org.opencontainers.image.vendor"="llaville"
LABEL "org.opencontainers.image.licenses"="MIT"
LABEL "org.opencontainers.image.ref.name"="${PHP_VERSION}-mods"
LABEL "org.opencontainers.image.title"="PHP-FPM ${PHP_VERSION}-mods"
LABEL "org.opencontainers.image.description"="PHP-FPM ${PHP_VERSION}-mods"

###
### Ports
###
EXPOSE 9000

###
### Entrypoint
###
CMD ["/usr/local/sbin/php-fpm"]
ENTRYPOINT ["/docker-entrypoint.sh"]
