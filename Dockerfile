FROM composer:latest

ARG UNAME=user
ARG UID=1000
ARG GID=1000

RUN addgroup -g ${GID} ${UNAME}
RUN adduser -D -u ${UID} -G ${UNAME} ${UNAME}

RUN apk update

RUN apk add --no-cache \
        ncurses-libs \
        ncurses \
        libxslt \
        libxslt-dev \
        autoconf \
        alpine-sdk

RUN docker-php-ext-install xsl

RUN pecl install xdebug-2.7.1 && docker-php-ext-enable xdebug

ENV HOME=/home/${UNAME}
ENV COMPOSER_HOME="${HOME}/.composer"
ENV COMPOSER_CACHE_DIR="${COMPOSER_HOME}/cache"

ENV ROBO_HOME="/robo/"
ENV PATH="${ROBO_HOME}/bin:${PATH}"

RUN mkdir $ROBO_HOME
RUN chown user:user $ROBO_HOME


USER $UNAME

RUN composer global require hirak/prestissimo

WORKDIR $ROBO_HOME
COPY --chown=1000:1000 . $ROBO_HOME

RUN chmod +x $ROBO_HOME/entrypoint.sh

RUN composer install
RUN if [ -f $ROBO_HOME/sami.phar ]; then \
    curl -O http://get.sensiolabs.org/sami.phar; \
    fi

RUN cp sami.phar $ROBO_HOME/bin/sami
RUN chmod +x $ROBO_HOME/bin/sami


WORKDIR /app
ENTRYPOINT ["/robo/entrypoint.sh"]
CMD ["list"]

