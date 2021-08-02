# syntax=docker/dockerfile:1
ARG PHP_VERSION=8.0

FROM local/php-fpm:${PHP_VERSION}-prod
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
LABEL "org.opencontainers.image.ref.name"="${PHP_VERSION}-work"
LABEL "org.opencontainers.image.title"="PHP-FPM ${PHP_VERSION}-work"
LABEL "org.opencontainers.image.description"="PHP-FPM ${PHP_VERSION}-work"

###
### Envs
###
ENV BASH_PROFILE=".bashrc"

###
### Install Common Tools
###
RUN set -eux \
	&& DEBIAN_FRONTEND=noninteractive apt-get update -qq \
	&& DEBIAN_FRONTEND=noninteractive apt-get install -qq -y --no-install-recommends --no-install-suggests apt-utils \
	&& DEBIAN_FRONTEND=noninteractive apt-get install -qq -y --no-install-recommends --no-install-suggests \
		apt-transport-https \
		ca-certificates \
		curl \
		dirmngr \
		gnupg \
		ack-grep \
		aspell \
		autoconf \
		automake \
		bash-completion \
		binutils \
		build-essential \
		bzip2 \
		certbot \
		coreutils \
		dnsutils \
		dos2unix \
		file \
		gawk \
		gcc \
		git \
		ghostscript \
		gsfonts \
		hostname \
		imagemagick \
		iputils-ping \
		jq \
		less \
		libc-dev \
		libffi-dev \
		libssl-dev \
		libyaml-dev \
		locales \
		make \
		moreutils \
		mariadb-client \
		mupdf \
		mupdf-tools \
		nano \
		net-tools \
		netcat \
		openssh-client \
		patch \
		patchelf \
		postgresql-client \
		redis-tools \
		rsync \
		shellcheck \
		silversearcher-ag \
		subversion \
		sudo \
		tree \
		unzip \
		vim \
		w3m \
		wget \
		whois \
		xz-utils \
		yarn \
		zip \
		zlib1g-dev \
		zsh \
	&& DEBIAN_FRONTEND=noninteractive apt-get purge -qq -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false apt-utils \
	&& rm -rf /var/lib/apt/lists/* \
	\
	&& (find /usr/local/bin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
	&& (find /usr/local/lib -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
	&& (find /usr/local/sbin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true)

###
### Install custom software
###

###
### Configure Bash
###
RUN \
	{ \
		echo 'PATH="${PATH}:${HOME}/.composer/vendor/bin"'; \
		echo 'PATH="${PATH}:/usr/local/bin:/usr/local/sbin"'; \
		echo "export PATH"; \
		echo ". /etc/bash-devilbox"; \
		echo "if [ -d /etc/bashrc-devilbox.d/ ]; then"; \
		echo "    for f in /etc/bashrc-devilbox.d/*.sh ; do"; \
		echo "        if [ -r \"\${f}\" ]; then"; \
		echo "            . \"\${f}\""; \
		echo "        fi"; \
		echo "    done"; \
		echo "    unset f"; \
		echo "fi"; \
	} | tee -a /home/${MY_USER}/${BASH_PROFILE} /root/${BASH_PROFILE} \
	&& chown ${MY_USER}:${MY_GROUP} /home/${MY_USER}/${BASH_PROFILE}

###
### Copy artifacts
###
# Please refer to https://docs.docker.com/engine/reference/builder/#arg for argument scope
ARG PHP_VERSION=$PHP_VERSION
COPY ./data/php-ini.d/php-${PHP_VERSION}.ini /usr/local/etc/php/conf.d/xxx-devilbox-default-php.ini
COPY ./data/php-fpm.conf/php-fpm-${PHP_VERSION}.conf /usr/local/etc/php-fpm.conf
COPY ./data/docker-entrypoint.sh /docker-entrypoint.sh
COPY ./data/docker-entrypoint.d/*.sh /docker-entrypoint.d/
COPY ./data/bash-devilbox /etc/bash-devilbox
COPY ./data/sudo-devilbox /etc/sudoers.d/devilbox

###
### Volumes
###
VOLUME /shared/backups
VOLUME /var/log/php
VOLUME /var/mail

###
### Ports
###
EXPOSE 9000

###
### Where to start inside the container
###
WORKDIR /shared/httpd

###
### Entrypoint
###
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
ENTRYPOINT ["/docker-entrypoint.sh"]
