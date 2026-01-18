# Build Stage 1: PHP Dependencies
FROM php:8.2-fpm-alpine as vendor

# Install system dependencies
RUN apk add --no-cache \
    oniguruma-dev \
    libxml2-dev \
    bash \
    curl \
    libpng-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    bcmath \
    xml \
    gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY composer.json composer.lock ./
# Note: Scripts are enabled to allow Laravel's post-autoload-dump scripts to run later if needed
# but we run with --no-autoloader first to leverage cache
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Build Stage 2: Frontend Assets
FROM node:20-alpine as frontend

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# Stage 3: Final App Image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    bash \
    sed \
    ca-certificates \
    oniguruma-dev \
    libxml2-dev \
    libpng-dev

# Install PHP extensions in the final image as well
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    bcmath \
    xml \
    gd

# Configure Nginx
COPY nginx.conf /etc/nginx/http.d/default.conf

WORKDIR /app

# Copy application from build stages
COPY --from=vendor /app/vendor /app/vendor
COPY --from=frontend /app/public/build /app/public/build
COPY . /app

# Finalize Composer Autoload (We need composer in this stage too if we want to dump-autoload here)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer dump-autoload --optimize --no-dev

# Prepare Directories and Permissions
RUN mkdir -p /app/storage/framework/{sessions,views,cache} \
    && mkdir -p /app/bootstrap/cache \
    && chmod -R 777 /app/storage /app/bootstrap/cache

# Copy startup script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
