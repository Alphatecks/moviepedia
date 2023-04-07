<?php

namespace App\Repository;

use App\interfaces\MovieGenreRepositoryInterface;

declare(strict_types=1);


class MovieGenreRepository implements MovieGenreRepositoryInterface{

    public function create_moviegenre(array $data){
       return MovieGenre::create([]);
    }

    public function get_all_moviegenres(){

    }
    public function update_movie_genre(){

    }
    public function delete_movie_genre(){

    }
}
