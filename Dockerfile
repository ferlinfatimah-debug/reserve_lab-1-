FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo mbstring exif pcntl bcmath gd

# Enable mod_rewrite
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy all files
COPY . .

# Fix permissions
RUN chown -R www-data:www-data . && chmod -R 755 storage bootstrap/cache

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend
RUN npm install && npm run build

# Setup Laravel
RUN cp .env.example .env && php artisan key:generate

# Apache config
RUN echo '<VirtualHost *:80>\n    DocumentRoot /var/www/html/public\n    <Directory /var/www/html/public>\n        AllowOverride All\n        Options Indexes FollowSymLinks\n        Require all granted\n        RewriteEngine On\n        RewriteCond %{REQUEST_FILENAME} !-d\n        RewriteCond %{REQUEST_FILENAME} !-f\n        RewriteRule ^ index.php [QSA,L]\n    </Directory>\n    <Directory /var/www/html/public/storage>\n        <FilesMatch "\\.(jpg|jpeg|png|gif|ico|css|js)$">\n            Header set Cache-Control "max-age=31536000"\n        </FilesMatch>\n    </Directory>\n</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
