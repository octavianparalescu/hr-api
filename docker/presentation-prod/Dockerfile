ARG PHP_VERSION
FROM php:${PHP_VERSION}-apache

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="5000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="50" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN docker-php-ext-install mysqli pdo pdo_mysql opcache
RUN apt-get update && apt-get install sendmail mailutils git zip -y && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick
RUN a2enmod rewrite
RUN a2enmod headers
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN usermod -u 6666 www-data
RUN service apache2 restart

ENV APACHE_DOCUMENT_ROOT /project/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" >> /usr/local/etc/php/conf.d/sendmail.ini
RUN sed -i '/#!\/bin\/sh/aservice sendmail restart' /usr/local/bin/docker-php-entrypoint
RUN sed -i '/#!\/bin\/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint
