<?php

declare (strict_types = 1);

namespace App\interfaces;

interface MovieRepositoryInterface
{
    public function create_movie(array $movie);
    public function get_all_movies();
    public function get_single_movie($id);
    public function update_movie(array $movie,$id);
    public function delete_movie($id);
}
