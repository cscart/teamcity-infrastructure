ARG PHP_VERSION=7.0.30
FROM protopopys/docker-php:${PHP_VERSION}-fpm-alpine3.7
#
LABEL maintainer="Protopopys <protopopys@gmail.com>"
#
ENV APP_HOME=/var/www/html/project
ARG TZ=UTC
ARG PROJECT=webhook
#
COPY --chown=daemon:daemon ${PROJECT} ${APP_HOME}
#
RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone