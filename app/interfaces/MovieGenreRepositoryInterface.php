<?php

declare (strict_types = 1);

namespace App\interfaces;

interface MovieGenreRepositoryInterface
{
    public function create_moviegenre(array $data);
    public function get_all_moviegenres();
    public function update_movie_genre(array $data, $id);
    public function delete_movie_genre($id);
}
