# Build Stage 1
# Compile Composer dependencies
FROM composer AS composer
WORKDIR /var/www
COPY . /var/www


RUN composer install --ignore-platform-reqs --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Build Stage 2
# PHP Alpine image, we install Apache on top of it
FROM alpine:3.14

# Concatenated RUN commands
RUN apk add --no-cache zip unzip imagemagick libzip-dev libpng-dev libxml2-dev libmcrypt-dev curl gnupg apache2 \
     php7 php7-imagick php7-apache2 php7-mbstring php7-session php7-json php7-openssl php7-tokenizer php7-pdo php7-pdo_mysql php7-fileinfo php7-ctype \
     php7-xmlreader php7-xmlwriter php7-xml php7-simplexml php7-gd php7-bcmath php7-zip php7-dom php7-posix php7-calendar libc6-compat libstdc++ supervisor\
    && mkdir -p /run/apache2 \
    && rm  -rf /tmp/*

# Apache configuration
COPY /.docker/apache.conf /etc/apache2/conf.d

# Make supervisor log directory
RUN mkdir -p /var/log/supervisor

ARG BUILDTIME_NODE_ENV
# Copy local supervisord.conf to the conf.d directory
COPY --chown=root:root /source/supervisord-${BUILDTIME_NODE_ENV}.conf /etc/supervisor/conf.d/supervisord.conf

# custom commands
COPY source/queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf
COPY source/task-scheduler.conf /etc/supervisor/conf.d/task-scheduler.conf

#RUN chown -vhR www:www /var/log

# PHP configuration
#RUN wget https://elasticache-downloads.s3.amazonaws.com/ClusterClient/PHP-7.3/latest-64bit
#RUN tar -zxvf latest-64bit
#RUN mv amazon-elasticache-cluster-client.so /usr/lib/php7/modules/
COPY /.docker/00_php.ini /etc/php7/conf.d

# Script permission

ADD /.docker/docker-entrypoint-${BUILDTIME_NODE_ENV}.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

# Copy app files
WORKDIR /var/www
COPY . /var/www

#copy vendor artifacts
COPY --from=composer /var/www/vendor/ /var/www/vendor/

# Run script
EXPOSE 80

ENTRYPOINT ["/docker-entrypoint.sh"]
