FROM php:8.4-fpm

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl unzip zip libpq-dev libzip-dev postgresql-client \
        libicu-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql pgsql bcmath zip pcntl opcache intl gd exif \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node.js + npm (rasmiy node image'dan olinadi)
COPY --from=node:22-bookworm-slim /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm-slim /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

# www-data ni host foydalanuvchisi ID'siga moslaymiz:
# src/ ichida yaratilgan fayllar sizniki bo'ladi (root emas)
RUN groupmod -o -g ${GROUP_ID} www-data \
    && usermod -o -u ${USER_ID} -g ${GROUP_ID} www-data

# Composer/npm keshlari src/ ni ifloslantirmasligi uchun
ENV HOME=/tmp \
    COMPOSER_HOME=/tmp/composer \
    npm_config_cache=/tmp/npm-cache

WORKDIR /var/www
USER www-data
EXPOSE 9000
CMD ["php-fpm"]