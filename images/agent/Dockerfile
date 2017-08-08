FROM jetbrains/teamcity-minimal-agent:latest

MAINTAINER Alexander Bolshakov <abolshakov@cs-cart.com>

RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apt-get update && apt-get install -y \
    wget \
    git \
    python-software-properties \
    software-properties-common

RUN add-apt-repository -y ppa:ondrej/php
RUN add-apt-repository -y "deb http://apt.postgresql.org/pub/repos/apt/ xenial-pgdg main"
RUN wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -

RUN apt-get update && apt-get install -y \
    postgresql-client-9.6 \
    mysql-client-5.7 \
    php7.1-cli \
    php7.1-common \
    php7.1-curl \
    php7.1-xml \
    php7.1-gd \
    php7.1-gettext \
    php7.1-iconv \
    php7.1-imagick \
    php7.1-intl \
    php7.1-json \
    php7.1-mbstring \
    php7.1-mcrypt \
    php7.1-pgsql \
    php7.1-zip \
    php7.1-mysql \
    php7.1-ftp    

ENV PATH "/composer/vendor/bin:$PATH"
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV COMPOSER_VERSION 1.4.2

RUN curl -s -f -L -o /tmp/installer.php https://raw.githubusercontent.com/composer/getcomposer.org/da290238de6d63faace0343efbdd5aa9354332c5/web/installer \
 && php -r " \
    \$signature = '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410'; \
    \$hash = hash('SHA384', file_get_contents('/tmp/installer.php')); \
    if (!hash_equals(\$signature, \$hash)) { \
        unlink('/tmp/installer.php'); \
        echo 'Integrity check failed, installer is either corrupt or worse.' . PHP_EOL; \
        exit(1); \
    }" \
 && php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION} \
 && rm /tmp/installer.php \
 && composer --ansi --version --no-interaction
