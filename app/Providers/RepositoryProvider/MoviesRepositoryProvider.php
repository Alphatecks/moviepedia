<?php

namespace App\Providers\RepositoryProvider;

use App\interfaces\MovieRepositoryInterface;
use App\Repository\MovieRepository;
use Illuminate\Support\ServiceProvider;

class MoviesRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
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
