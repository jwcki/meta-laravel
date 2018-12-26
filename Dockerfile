FROM php:7.2-apache

RUN apt-get update \
  && docker-php-ext-install bcmath \
  && docker-php-ext-install pdo_mysql \
  # && apt-get -y install supervisor \
  && apt-get clean \
  && a2enmod rewrite

ENV DstDir /var/www/site

WORKDIR /etc/apache2/sites-available/
RUN sed -i -e "s!/var/www/html!${DstDir}/public!" 000-default.conf

# WORKDIR /etc/supervisor/conf.d/
# COPY docker/supervisor.conf laravel-worker.conf

WORKDIR ${DstDir}
COPY --chown=www-data:www-data ./ ${DstDir}
# RUN chown -R www-data:www-data ${DstDir}
# RUN chmod +x ${DstDir}/docker/start.sh

# CMD ${DstDir}/docker/start.sh
