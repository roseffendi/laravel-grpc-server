<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Grpc\Contracts\Validator::class, \App\Grpc\LaravelValidator::class);
        $this->app->bind(\Protobuf\Identity\AuthServiceInterface::class, \App\Grpc\Services\Identity\AuthService::class);

        if(!$this->app->environment('production')) {
            $this->app->singleton(\App\Grpc\Contracts::class, \App\Grpc\RoadrunnerDumper::class);
            $this->app->singleton('dumper', \App\Grpc\RoadrunnerDumper::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
