<?php

use Spiral\Goridge;
use Spiral\RoadRunner;
use Protobuf\Identity\AuthServiceInterface;

ini_set('display_errors', 'stderr');

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->singleton(
    App\Grpc\Contracts\Kernel::class,
    App\Grpc\Kernel::class
);

$app->singleton(
    \App\Grpc\Contracts\ServiceInvoker::class, 
    \App\Grpc\LaravelServiceInvoker::class
);

$kernel = $app->make(App\Grpc\Contracts\Kernel::class);

$kernel->registerService(AuthServiceInterface::class);

$w = new RoadRunner\Worker(new Goridge\StreamRelay(STDIN, STDOUT));

$kernel->serve($w);