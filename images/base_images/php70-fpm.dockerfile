ARG REGISTRY
ARG PHP_VERSION
FROM ${REGISTRY}cscart_core/php:${PHP_VERSION}-fpm-alpine3.7
LABEL maintainer="Protopopys <protopopys@gmail.com>"

ARG PROJECT
COPY --chown=root:root ${PROJECT}/php/config_templates/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/project