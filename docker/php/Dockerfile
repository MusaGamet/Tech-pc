# Используем официальный образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Копируем исходный код приложения в контейнер
COPY ../app /var/www/html/

# Включаем модуль Apache rewrite
RUN a2enmod rewrite

# Устанавливаем права на запись для папки с данными
RUN chown -R www-data:www-data /var/www/html

# Открываем порт 80
EXPOSE 80