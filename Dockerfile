FROM composer:latest

ARG UNAME=user
ARG UID=1000
ARG GID=1000


RUN addgroup -g ${GID} ${UNAME}
RUN adduser -D -u ${UID} -G ${UNAME} ${UNAME}

#USER $UNAME

RUN apk update

RUN apk add --no-cache \
        ncurses-libs \
        ncurses \
        libxslt \
        libxslt-dev

RUN docker-php-ext-install xsl

RUN mkdir /global
RUN mkdir /global/composer
RUN mkdir /global/cache

ENV COMPOSER_CACHE_DIR=/global/cache
ENV COMPOSER_HOME=/global/composer
RUN composer global require hirak/prestissimo

RUN chmod -R 777 /global



RUN mkdir /main
WORKDIR /main
COPY composer.json composer.lock /main/
COPY src /main/src/
COPY views/sami /main/views/sami/
COPY .planb /main/.planb/
COPY RoboFile.php  /main/RoboFile.php

COPY entrypoint.sh /main/entrypoint.sh
RUN chmod +x /main/entrypoint.sh

RUN composer install
RUN chmod -R 777 /global/cache

RUN curl -O http://get.sensiolabs.org/sami.phar && \
    mv sami.phar /main/bin/sami && \
    chmod +x /main/bin/sami


ENV PATH="/main/bin:${PATH}"

WORKDIR /app
ENTRYPOINT ["/main/entrypoint.sh"]
CMD ["list"]
