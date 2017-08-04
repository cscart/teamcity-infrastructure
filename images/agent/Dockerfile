FROM jetbrains/teamcity-minimal-agent:latest

MAINTAINER Alexander Bolshakov <abolshakov@cs-cart.com>

RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apt-get update && apt-get install -y \
    git \
    python-software-properties \
    software-properties-common

RUN add-apt-repository -y ppa:ondrej/php

RUN apt-get update && apt-get install -y \
    php7.1