FROM php:8.1-cli

COPY . /app

WORKDIR /app

CMD [ "php", "./index.php" ]