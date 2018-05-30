FROM postgres:9.6
LABEL maintainer="Protopopys <protopopys@gmail.com>"
COPY --chown=root:root set-pg-conf.sh /docker-entrypoint-initdb.d/set-config.sh
RUN chmod +x /docker-entrypoint-initdb.d/set-config.sh