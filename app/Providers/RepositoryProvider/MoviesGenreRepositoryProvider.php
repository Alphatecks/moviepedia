<?php

namespace App\Providers\RepositoryProvider;

use App\interfaces\MovieGenreRepositoryInterface;
use App\Repository\MovieGenreRepository;
use Illuminate\Support\ServiceProvider;

class MoviesGenreRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MovieGenreRepositoryInterface::class, MovieGenreRepository::class);
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
