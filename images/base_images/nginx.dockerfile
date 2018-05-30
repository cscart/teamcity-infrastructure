ARG REGISTRY
ARG NGINX_VERSION
FROM ${REGISTRY}cscart_core/nginx:${NGINX_VERSION}-alpine3.7
LABEL maintainer="Protopopys <protopopys@gmail.com>"

ARG PROJECT
COPY --chown=root:root ${PROJECT}/nginx/config_templates /etc/nginx/templates
#COPY --chown=root:root common_files/nginx/ssl /etc/nginx/ssl

RUN mkdir -p /var/www/html/project \
 && mkdir -p /etc/nginx/xtra
# && chmod 700 /etc/nginx/ssl \
# && chmod 644 /etc/nginx/ssl/*