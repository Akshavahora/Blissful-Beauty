#!/bin/bash
set -e

# If vendor not present and composer.json exists, install deps
if [ -f /var/www/html/composer.json ] && [ ! -d /var/www/html/vendor ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

exec docker-php-entrypoint apache2-foreground
