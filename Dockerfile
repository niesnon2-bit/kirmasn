# تمكين mysqli و pdo_mysql — مطلوب لاتصال المشروع بـ MySQL على Railway
FROM php:8.4-cli-bookworm

RUN docker-php-ext-install mysqli pdo_mysql opcache

WORKDIR /app
COPY . /app

# Railway يضع المنفذ في متغير PORT
EXPOSE 8080
CMD ["sh", "-c", "exec php -S 0.0.0.0:${PORT:-8080} -t /app"]
