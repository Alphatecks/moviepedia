<?php

namespace App\Repository;

use App\interfaces\MovieRepositoryInterface;
use App\Models\Movies;

class MovieRepository implements MovieRepositoryInterface
{
    public function create_movie(array $movie)
    {
        return Movies::create([
            "movie_name" => $movie['movie_name'],
            "genre_id" => $movie['genre_id'],
            "details" => $movie['details'],
        ]);
    }
    public function get_all_movies()
    {
        return Movies::with('movie_genre')->latest()->paginate(20);
    }
    public function get_single_movie($id)
    {
        return Movies::with('movie_genre')->where('id', $id)->latest()->get();
    }
    public function update_movie(array $movie, $id)
    {
        $m = Movies::find($id);

        $m->movie_name = $movie['movie_name'] ?? $m->movie_name;
        $m->genre_id = $movie['genre_id'] ?? $m->genre_id;
        $m->details = $movie['details'] ?? $m->details;
        return $m->save();
    }
    public function delete_movie($id)
    {
        return Movies::find($id)->delete();
    }
}
