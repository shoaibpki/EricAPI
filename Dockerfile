FROM php:7.3-cli
COPY . /usr/public/myapp
WORKDIR /usr/public/myapp
CMD [ "php", "./index.php" ]