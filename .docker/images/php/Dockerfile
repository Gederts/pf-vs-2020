FROM php:7.4-fpm as base

# COPY php.ini /data/php74/php.ini

RUN docker-php-ext-install opcache


RUN apt update && apt install -y git zip

# Install Laravel dependencies
RUN docker-php-ext-install pdo pdo_mysql

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer

# Alternate way to install composer: COPY --from=composer /usr/local/bin/composer /usr/local/bin/composer