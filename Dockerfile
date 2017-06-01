FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev git libicu-dev g++ libfontconfig libxrender1 libxext6 openssh-client mysql-client-5.5 faketime \
    --no-install-recommends && \
    rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql zip mbstring intl
RUN pecl install xdebug
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN useradd -m -u 1000 -g 33 user
RUN mkdir -p /usr/src/app
RUN chown 1000:33 /usr/src/app
WORKDIR /usr/src/app
ENV PATH "$PATH:vendor/bin:bin"
COPY composer.json /usr/src/app/
COPY composer.lock /usr/src/app/
COPY . /usr/src/app
RUN chown -R 1000:33 /usr/src/app
USER user
RUN V=0 php $(which composer) install --prefer-dist --no-suggest --no-scripts
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY . /usr/src/app
USER root

