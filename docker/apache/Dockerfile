FROM php:7.1-apache
MAINTAINER Rion Dooley <deardooley@gmail.com>

RUN apt-get update && \
    apt-get install -y git zip unzip vim-tiny \
                       libfreetype6-dev \
                       libjpeg62-turbo-dev \
                       libmcrypt-dev \
                       libpng-dev \
                       libicu-dev && \
    docker-php-ext-install -j$(nproc) iconv && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install mcrypt && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install iconv && \
    docker-php-ext-install json && \
    docker-php-ext-install opcache && \
    docker-php-ext-install intl && \
    apt-get -y autoremove && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug-2.6.0 && \
    echo "#zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20160303/xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "#xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "#xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "#xdebug.remote_port = 9000" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "#xdebug.scream=0" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "#xdebug.show_local_vars=1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "#xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN /usr/sbin/a2enmod rewrite

ADD 000-laravel.conf /etc/apache2/sites-available/
ADD 001-laravel-ssl.conf /etc/apache2/sites-available/
RUN /usr/sbin/a2dissite '*' && /usr/sbin/a2ensite 000-laravel 001-laravel-ssl

RUN /usr/bin/curl -sS https://getcomposer.org/installer |/usr/local/bin/php
RUN /bin/mv composer.phar /usr/local/bin/composer
RUN /usr/local/bin/composer create-project laravel/laravel /var/www/laravel --prefer-dist
RUN usermod -u 1000 "www-data" && \
    /bin/chown www-data:www-data -R /var/www/laravel/storage /var/www/laravel/bootstrap/cache

WORKDIR /var/www/laravel

EXPOSE 80
EXPOSE 443

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
