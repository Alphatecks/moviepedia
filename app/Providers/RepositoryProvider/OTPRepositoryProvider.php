<?php

namespace App\Providers\RepositoryProvider;

use App\interfaces\OTPRepositoryInterface;
use App\Repository\OTPRepository;
use Illuminate\Support\ServiceProvider;

class OTPRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OTPRepositoryInterface::class, OTPRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
