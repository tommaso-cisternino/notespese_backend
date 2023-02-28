FROM php:8.1-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libfreetype6-dev \
    locales \
    zip \
    vim \
    unzip \
    git \
    curl && \
    rm -rf /var/lib/apt/lists/*


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www
COPY --chown=www:www . /var/www
RUN chown -vhR www:www /var/www
USER www
# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD bash -c "composer install && cp .env.example .env && php artisan key:generate && php artisan migrate && php artisan jwt:secret && mkdir -p storage/framework/cache/data/ && php artisan cache:clear && php-fpm"
