<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RegisterUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Passed data.
     * 
     * @var array
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param   array   $data
     * 
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = new User;

        $user->email = $this->data['email'];
        $user->name = $this->data['name'];
        $user->password = bcrypt($this->data['password']);

        $user->save();
    }
}
