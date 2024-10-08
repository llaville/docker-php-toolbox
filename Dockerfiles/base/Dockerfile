# syntax=docker/dockerfile:1
ARG PHP_VERSION=8.0

FROM php:${PHP_VERSION}-fpm

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
LABEL "org.opencontainers.image.ref.name"="${PHP_VERSION}-base"
LABEL "org.opencontainers.image.title"="PHP-FPM ${PHP_VERSION}-base"
LABEL "org.opencontainers.image.description"="PHP-FPM ${PHP_VERSION}-base"

###
### Envs
###
ENV MY_USER="devilbox" \
    MY_GROUP="devilbox" \
    MY_UID="1000" \
    MY_GID="1000"

###
### User/Group
###
RUN set -eux \
    && groupadd -g ${MY_GID} -r ${MY_GROUP} \
    && useradd -u ${MY_UID} -m -s /bin/bash -g ${MY_GROUP} -l ${MY_USER}

###
### Upgrade (install ps)
###
RUN set -eux \
    && DEBIAN_FRONTEND=noninteractive apt-get update -qq \
    && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y --no-install-recommends --no-install-suggests procps \
    && rm -rf /var/lib/apt/lists/*

###
### Configure
###
RUN set -eux \
    && rm -rf /usr/local/etc/php-fpm.d \
    && mkdir -p /usr/local/etc/php-fpm.d \
    && mkdir -p /var/lib/php/session \
    && mkdir -p /var/lib/php/wsdlcache \
    && chown -R devilbox:devilbox /var/lib/php/session \
    && chown -R devilbox:devilbox /var/lib/php/wsdlcache

###
### Copy artifacts
###
# Please refer to https://docs.docker.com/engine/reference/builder/#arg for argument scope
ARG PHP_VERSION=$PHP_VERSION
COPY ./data/php-ini.d/php-${PHP_VERSION}.ini /usr/local/etc/php/conf.d/xxx-devilbox-default-php.ini
COPY ./data/php-fpm.conf/php-fpm-${PHP_VERSION}.conf /usr/local/etc/php-fpm.conf
COPY ./data/docker-entrypoint.sh /docker-entrypoint.sh
COPY ./data/docker-entrypoint.d /docker-entrypoint.d

###
### Ports
###
EXPOSE 9000

###
### Entrypoint
###
CMD ["/usr/local/sbin/php-fpm"]
ENTRYPOINT ["/docker-entrypoint.sh"]
