<?php

namespace App\Providers\RepositoryProvider;

use App\Repository\UserAuthRepository;
use Illuminate\Support\ServiceProvider;
use App\interfaces\UserAuthRepositoryInterface;

class UserAuthRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserAuthRepositoryInterface::class,UserAuthRepository::class);
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
