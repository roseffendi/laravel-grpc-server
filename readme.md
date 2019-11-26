# Laravel GRPC Server

This repository contain Laravel implementation of grpc server sample. This app run on top of https://github.com/spiral/php-grpc server which built on top of [roadrunner](https://roadrunner.dev/) server. Laravel grpc client sample can be found at https://github.com/roseffendi/laravel-grpc-client

### Setup

You can follow https://github.com/spiral/php-grpc to get started. Protos definition located at `./protos` directory. You can also use included `docker` configuration to start. It contains necessary steps to reproduce environment.

### Test

To run tests, run following command

```vendor/bin/phpunit```