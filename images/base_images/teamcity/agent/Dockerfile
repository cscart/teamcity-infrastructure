FROM jetbrains/teamcity-minimal-agent:latest

LABEL maintainer="Protopopys <protopopys@gmail.com>"

RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository -y ppa:openjdk-r/ppa && add-apt-repository -y ppa:git-core/ppa && apt-get update && \
    apt-get install -y git apt-transport-https ca-certificates && \
    \
    apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 9DC858229FC7DD38854AE2D88D81803C0EBFCD88 && \
    echo "deb [arch=amd64] https://download.docker.com/linux/ubuntu xenial stable" > /etc/apt/sources.list.d/docker.list && \
    \
    apt-cache policy docker-ce && \
    apt-get update && \
    apt-get install -y docker-ce=18.03.0~ce-0~ubuntu && \
    systemctl disable docker && \
    curl -SL https://github.com/docker/compose/releases/download/1.20.1/docker-compose-Linux-x86_64 -o /usr/local/bin/docker-compose && chmod +x /usr/local/bin/docker-compose \
 && apt-get update && apt-get install -y \
    wget \
    zip \
    unzip \
    python-software-properties \
    software-properties-common \
\
 && add-apt-repository -y ppa:ondrej/php \
 && add-apt-repository -y "deb http://apt.postgresql.org/pub/repos/apt/ xenial-pgdg main" \
 && wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add - \
\
 && apt-get update && apt-get install -y \
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
    php7.1-ftp \
    php7.1-soap

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
#For https://github.com/cscart/docs
ENV DOCS_DEPS \
        Sphinx==1.5.5 \
        sphinxcontrib-fancybox
RUN apt-get -y install gettext python-pip --no-install-recommends \
# && pip install -U pip \
 && pip install -U setuptools \
 && pip install ${DOCS_DEPS} \
 && composer global require "phpunit/phpunit=4.8.*" \
 && composer global require "phpunit/dbunit=1.4.*"