# syntax=docker/dockerfile:1
ARG PHP_VERSION=8.0

FROM local/php-fpm:${PHP_VERSION}-mods
MAINTAINER "llaville" <pear@laurent-laville.org>

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
LABEL "org.opencontainers.image.ref.name"="${PHP_VERSION}-prod"
LABEL "org.opencontainers.image.title"="PHP-FPM ${PHP_VERSION}-prod"
LABEL "org.opencontainers.image.description"="PHP-FPM ${PHP_VERSION}-prod"

###
### Install
###
RUN set -eux \
	&& DEBIAN_FRONTEND=noninteractive apt-get update -qq \
	&& DEBIAN_FRONTEND=noninteractive apt-get install -qq -y --no-install-recommends --no-install-suggests apt-utils \
	&& DEBIAN_FRONTEND=noninteractive apt-get install -qq -y --no-install-recommends --no-install-suggests \
		locales-all \
		postfix \
		postfix-pcre \
		cron \
		rsyslog \
		socat \
		supervisor \
	&& DEBIAN_FRONTEND=noninteractive apt-get purge -qq -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false apt-utils \
	&& rm -rf /var/lib/apt/lists/* \
	\
	&& rm -rf /etc/supervisor* \
	&& mkdir -p /var/log/supervisor \
	&& mkdir -p /etc/supervisor/conf.d \
	&& mkdir -p /etc/supervisor/custom.d \
	&& chown devilbox:devilbox /etc/supervisor/custom.d \
	\
	&& (find /usr/local/bin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
	&& (find /usr/local/lib -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
	&& (find /usr/local/sbin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true)

###
### Copy artifacts
###
COPY ./data/docker-entrypoint.sh /docker-entrypoint.sh
COPY ./data/docker-entrypoint.d/*.sh /docker-entrypoint.d/
COPY ./data/postfix.sh /usr/local/sbin/postfix.sh
COPY ./data/supervisord.conf /etc/supervisor/supervisord.conf

###
### Volumes
###
VOLUME /var/log/php
VOLUME /var/mail

###
### Ports
###
EXPOSE 9000

###
### Entrypoint
###
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
ENTRYPOINT ["/docker-entrypoint.sh"]
