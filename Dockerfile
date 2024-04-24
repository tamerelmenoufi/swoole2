FROM php:latest

RUN pecl install swoole && docker-php-ext-enable swoole

WORKDIR /app

COPY . .

CMD [ "php", "server.php" ]
