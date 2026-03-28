FROM php:8.4-apache

RUN apt-get update
RUN apt-get install -y libzip-dev zip libpq-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql mysqli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY apache.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

WORKDIR /var/www/html