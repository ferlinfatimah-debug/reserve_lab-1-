FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev zip unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo mbstring exif pcntl bcmath gd

# Enable Apache modules
RUN a2enmod rewrite headers

# Install Composer & Node.js
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

WORKDIR /var/www/html

COPY . .

# Permissions
RUN chown -R www-data:www-data . && chmod -R 755 storage bootstrap/cache

# Dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Setup
RUN cp .env.example .env && php artisan key:generate
RUN touch database/database.sqlite && chmod 666 database/database.sqlite
RUN php artisan migrate --force 2>&1 || true

# Apache VirtualHost
RUN cat > /etc/apache2/sites-available/000-default.conf << 'EOFVHOST'
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Options -Indexes +FollowSymLinks
        Require all granted
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php [L]
        </IfModule>
    </Directory>

    <Directory /var/www/html>
        AllowOverride None
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOFVHOST

# Remove default site and enable correct one
RUN a2dissite 000-default 2>/dev/null || true
RUN a2ensite 000-default

EXPOSE 80
CMD ["apache2-foreground"]
