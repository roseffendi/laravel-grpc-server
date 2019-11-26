#
# Installing composer dependecies
#

FROM composer:1.9 as vendor

WORKDIR /app

COPY . .

RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --no-suggest --optimize-autoloader

#
# Build rr-grpc and protoc-gen-php-grpc
# Compile proto files.
#

FROM golang:1.13-alpine as golang

RUN apk --update --no-cache add bash

RUN apk --update --no-cache add \
         --repository=http://dl-cdn.alpinelinux.org/alpine/edge/main \
         --repository=http://dl-cdn.alpinelinux.org/alpine/edge/community \
         grpc

WORKDIR /app

COPY --from=vendor /app .

RUN bash vendor/spiral/php-grpc/build.sh build Linux linux amd64
RUN bash vendor/spiral/php-grpc/build.sh build_protoc Linux linux amd64

RUN protoc --plugin=./vendor/spiral/php-grpc/protoc-gen-php-grpc --php_out=./generated --php-grpc_out=./generated protos/**/*.proto

#
# Build app image
#

FROM php:7.3-zts-alpine

RUN apk add --update --no-cache --virtual .build-deps \
        curl \
        autoconf \
        gcc \
        make \
        g++ \
        zlib-dev

WORKDIR /var/www

RUN docker-php-ext-install pdo_mysql bcmath

COPY --from=golang /app .

RUN apk del .build-deps

EXPOSE 3000

CMD ["vendor/spiral/php-grpc/rr-grpc", "serve", "-v", "-d"]