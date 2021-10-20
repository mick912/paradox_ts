FROM php:7.4.24-fpm-alpine
RUN docker-php-ext-install pdo pdo_mysql

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN apk update
RUN apk upgrade
RUN apk add bash
RUN alias composer='php /usr/bin/composer'
WORKDIR /var/www/html/
COPY . .
RUN composer update
