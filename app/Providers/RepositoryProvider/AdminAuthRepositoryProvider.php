<?php

namespace App\Providers\RepositoryProvider;

use App\Repository\AdminAuthRepository;
use Illuminate\Support\ServiceProvider;
use App\interfaces\AdminAuthRepositoryInterface;

class AdminAuthRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AdminAuthRepositoryInterface::class,AdminAuthRepository::class);
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
