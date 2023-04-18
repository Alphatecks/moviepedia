<?php
declare (strict_types = 1);

namespace App\Repository;

use App\interfaces\MovieGenreRepositoryInterface;
use App\Models\MovieGenre;

class MovieGenreRepository implements MovieGenreRepositoryInterface
{

    public function create_moviegenre(array $data)
    {
        return MovieGenre::create([
            "genre" => $data['genre'],
        ]);
    }

    public function get_all_moviegenres()
    {
        return MovieGenre::latest()->get();
    }
    public function update_movie_genre(array $data, $id)
    {
        $movie_genre = MovieGenre::find($id);

        $movie_genre->genre = $data['genre'] ?? $movie_genre->genre;

        return $movie_genre->save();
    }
    public function delete_movie_genre($id)
    {
        return MovieGenre->find($id)->delete();
    }
}
