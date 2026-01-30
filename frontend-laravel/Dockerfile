FROM php:8.2-apache

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

# Copy Laravel project
COPY . .

# Install Composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 755 storage bootstrap/cache

# Enable Apache mods
RUN a2enmod rewrite
RUN a2enmod headers

# Create Apache config for port 8000
RUN cat > /etc/apache2/ports.conf <<EOF
Listen 8000
EOF

RUN cat > /etc/apache2/sites-available/000-default.conf <<'EOF'
<VirtualHost *:8000>
    ServerName localhost
    DocumentRoot /var/www/html/public
    
    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^ index.php [QSA,L]
        </IfModule>
    </Directory>
    
    <Directory /var/www/html>
        AllowOverride All
    </Directory>
</VirtualHost>
EOF

RUN a2ensite 000-default

EXPOSE 8000

CMD ["apache2-foreground"]
