FROM php:8.2-cli-alpine

RUN apk --no-cache add \
        git \
        icu-dev \
        bash \
        linux-headers && \
    docker-php-ext-install \
        intl \
        opcache \
        pdo_mysql \
        > /dev/null

# install apcu & xDebug
ENV XDEBUG_MODE=off
ENV XDEBUG_CONFIG=""
RUN apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
        && docker-php-ext-install pcntl sockets \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl install xdebug \
        && docker-php-ext-enable xdebug \
        && pecl clear-cache \
        && apk del .build-dependencies

RUN curl -sS https://getcomposer.org/installer | php -- --2 --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

ADD .docker/php/php.ini /usr/local/etc/php/conf.d/40-custom.ini

RUN addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser appuser && \
    chown appuser:appuser .

USER appuser

COPY --chown=appuser:appuser project/ ./
RUN composer install -q
