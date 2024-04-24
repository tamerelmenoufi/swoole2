FROM php:latest

RUN pecl install swoole && docker-php-ext-enable swoole

WORKDIR /app

COPY server.php .

CMD [ "php", "server.php" ]