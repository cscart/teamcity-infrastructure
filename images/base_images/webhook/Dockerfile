ARG REGISTRY
ARG PHP_VERSION
FROM protopopys/docker-php:${PHP_VERSION}-fpm-alpine3.7
LABEL maintainer="Protopopys <protopopys@gmail.com>"

ENV APP_HOME=/var/www/html/project
ARG TZ
ARG PROJECT=webhook

COPY --chown=daemon:daemon ${PROJECT} ${APP_HOME}

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime && echo ${TZ} > /etc/timezone