<?php

namespace Tests\Unit;

use App\Grpc\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GrpcKernelTest extends TestCase
{
    protected $kernel;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(
            App\Grpc\Contracts\Kernel::class,
            App\Grpc\Kernel::class
        );
        
        $this->app->singleton(
            \App\Grpc\Contracts\ServiceInvoker::class, 
            \App\Grpc\LaravelServiceInvoker::class
        );        

        $this->kernel = $this->app->make(Kernel::class);
    }

    public function testItCanRegisterService()
    {
        $this->kernel->registerService(\Protobuf\Identity\AuthServiceInterface::class);

        $this->assertTrue(true);
    }
}
