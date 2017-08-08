FROM debian:jessie
MAINTAINER  Kirill Protopopov <protopopys@gmail.com>

RUN apt-get update && apt-get install -y \
            supervisor \
            postfix \
            sasl2-bin \
            opendkim \
            opendkim-tools \
            rsyslog
RUN sed -i "s/inet_interfaces = localhost/inet_interfaces = all/g" /etc/postfix/main.cf \
 && sed -i "s/^mydestination.*/mydestination = \$myhostname, localhost.\$mydomain, localhost/g" /etc/postfix/main.cf
RUN echo >> /etc/postfix/main.cf


RUN mkdir -p /etc/postfix/certs && mkdir -p /etc/opendkim/domainkeys 
COPY init.sh /root/init.sh
COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY rsyslog.conf /etc/rsyslog.conf
COPY listen.conf /etc/rsyslog.d/listen.conf

CMD /root/init.sh;/usr/bin/supervisord -c /etc/supervisor/supervisord.conf
