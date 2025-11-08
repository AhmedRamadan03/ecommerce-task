FROM php:8.2-cli

WORKDIR /var/www

# تثبيت الاعتماديات
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    && apt-get clean

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ الملفات
COPY . .

# تثبيت الاعتماديات
RUN composer install --no-dev --optimize-autoloader

# إنشاء key للتطبيق إذا لم يكن موجود
RUN if [ ! -f .env ]; then \
        cp .env.example .env && \
        php artisan key:generate; \
    fi

EXPOSE 9000

CMD php artisan serve --host=0.0.0.0 --port=9000