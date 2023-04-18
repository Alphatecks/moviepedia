<?php

use App\Http\Controllers\Movies\MoviesController;
use App\Http\Controllers\Movies\MoviesGnereController;

Route::prefix('admin_restricted')->group(function () {

    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::group(['middleware' => ['auth:admin,admin-api']], function () {

        #movie genres
        Route::controller(MoviesGnereController::class)->group(function () {
            Route::post('/create_movie_genre', 'create_moviegenre');
            Route::get('/get_all_moviegenre', 'get_all_moviegenres');
            Route::put('/edit_moviegenre/{id}', 'update_movie_genre');
            Route::delete('/delete_movie_genre/{id}', 'delete_movie_genre');
        });

        Route::controller(MoviesController::class)->group(function () {
            Route::post('/create_movies', 'create_movies');
            Route::get('/get_all_movies','');
        });

    });

});
