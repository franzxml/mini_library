FROM php:8.2-apache
RUN docker-php-ext-install pdo pdo_sqlite \
&& a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
&& sed -ri -e 's!/var/www/!/var/www/html/public/!g' /etc/apache2/apache2.conf || true
COPY . /var/www/html
WORKDIR /var/www/html