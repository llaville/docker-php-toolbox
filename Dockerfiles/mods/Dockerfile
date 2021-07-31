# syntax=docker/dockerfile:1
ARG PHP_VERSION=8.0
ARG BUILD_VERSION=1

FROM local/php-fpm:${PHP_VERSION}-base as base

FROM base as builder
MAINTAINER "llaville" <pear@laurent-laville.org>

ARG DOCKER_PHP_EXTENSION_INSTALLER=1.2.45
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
FROM builder as build-version-1

FROM builder as build-version-80
RUN install-php-extensions amqp
RUN install-php-extensions apcu
RUN install-php-extensions ast
RUN install-php-extensions http
RUN install-php-extensions igbinary
RUN install-php-extensions imagick
RUN install-php-extensions lzf
RUN install-php-extensions mailparse
RUN install-php-extensions mcrypt
RUN install-php-extensions memcache
RUN install-php-extensions memcached
RUN install-php-extensions mongodb
RUN install-php-extensions msgpack
RUN install-php-extensions oauth
RUN install-php-extensions raphf
RUN install-php-extensions rdkafka
RUN install-php-extensions redis
RUN install-php-extensions solr
RUN install-php-extensions ssh2
RUN install-php-extensions uuid
RUN install-php-extensions vips
RUN install-php-extensions xdebug
RUN install-php-extensions xhprof
RUN install-php-extensions xlswriter
RUN install-php-extensions xmldiff
RUN install-php-extensions xmlrpc
RUN install-php-extensions yaml
RUN install-php-extensions zip

FROM builder as build-version-81
RUN install-php-extensions amqp
RUN install-php-extensions apcu
RUN install-php-extensions ast
RUN install-php-extensions http
RUN install-php-extensions igbinary
RUN install-php-extensions imagick
RUN install-php-extensions lzf
RUN install-php-extensions mcrypt
RUN install-php-extensions memcache
RUN install-php-extensions memcached
#RUN install-php-extensions mongodb
RUN install-php-extensions msgpack
RUN install-php-extensions oauth
RUN install-php-extensions raphf
RUN install-php-extensions redis
RUN install-php-extensions solr
RUN install-php-extensions ssh2
RUN install-php-extensions uuid
RUN install-php-extensions vips
RUN install-php-extensions xdebug
RUN install-php-extensions xhprof
RUN install-php-extensions xmldiff
#RUN install-php-extensions xmlrpc
#RUN install-php-extensions yaml
RUN install-php-extensions zip

FROM builder as build-version-74
RUN install-php-extensions amqp
RUN install-php-extensions apcu
RUN install-php-extensions ast
RUN install-php-extensions geoip
RUN install-php-extensions http
RUN install-php-extensions igbinary
RUN install-php-extensions imagick
RUN install-php-extensions jsmin
RUN install-php-extensions lzf
RUN install-php-extensions mailparse
RUN install-php-extensions mcrypt
RUN install-php-extensions memcache
RUN install-php-extensions memcached
RUN install-php-extensions mongodb
RUN install-php-extensions msgpack
RUN install-php-extensions oauth
RUN install-php-extensions raphf
RUN install-php-extensions rdkafka
RUN install-php-extensions redis
RUN install-php-extensions solr
RUN install-php-extensions ssh2
RUN install-php-extensions stomp
RUN install-php-extensions uploadprogress
RUN install-php-extensions uuid
RUN install-php-extensions vips
RUN install-php-extensions xdebug
RUN install-php-extensions xhprof
RUN install-php-extensions xlswriter
RUN install-php-extensions xmldiff
RUN install-php-extensions xmlrpc
RUN install-php-extensions yaml
RUN install-php-extensions zip

###
### Build final mods image
###
FROM build-version-${BUILD_VERSION} as after-condition

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
LABEL "org.opencontainers.image.authors"="llaville <pear@laurent-laville.org>"
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
