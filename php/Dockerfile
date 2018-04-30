FROM php:7.1-fpm
RUN apt-get update 
RUN docker-php-ext-install pdo_mysql

RUN curl -sL https://deb.nodesource.com/setup_9.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install nodejs -y
RUN npm -g update
RUN command -v node
RUN command -v npm