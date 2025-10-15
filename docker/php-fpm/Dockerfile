# docker/php-fpm/Dockerfile
ARG PHP_VERSION=8.3-fpm-alpine
FROM php:${PHP_VERSION}

# ---- System deps
RUN apk add --no-cache \
    bash git curl tzdata \
    icu-dev libzip-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    libxml2-dev oniguruma-dev \
    postgresql-dev \
    autoconf make g++ zip unzip

# ---- PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
    pdo_pgsql pgsql \
    mbstring bcmath intl gd xml zip opcache

# ---- phpredis
RUN pecl install redis \
    && docker-php-ext-enable redis

# ---- Xdebug
ARG ENABLE_XDEBUG=0
RUN if [ "$ENABLE_XDEBUG" = "1" ]; then \
    pecl install xdebug && docker-php-ext-enable xdebug ; \
    fi

# ---- Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# ---- Usuário não-root
ARG SYSTEM_USER=app
ARG SYSTEM_UID=1000
ARG SYSTEM_GID=1000
RUN addgroup -g ${SYSTEM_GID} -S ${SYSTEM_USER} \
    && adduser -S -D -H -u ${SYSTEM_UID} -G ${SYSTEM_USER} ${SYSTEM_USER}

WORKDIR /var/www/html
USER ${SYSTEM_USER}
# ---- Config files
COPY php.ini /usr/local/etc/php/php.ini
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000
