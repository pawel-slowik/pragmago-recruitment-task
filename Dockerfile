FROM php:7.4-cli

COPY --from=composer /usr/bin/composer /usr/local/bin/

RUN apt-get update && apt-get install -y git unzip

RUN mkdir /app

WORKDIR /app
