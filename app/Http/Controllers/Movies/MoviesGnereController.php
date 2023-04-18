<?php

namespace App\Http\Controllers\Movies;

use App\Http\Controllers\Controller;

class MoviesGnereController extends Controller
{
    private $movieGenreRepo;
    public function __construct(MovieGenreRepositoryInterface $movieGenreRepo)
    {
        $this->movieGenreRepo = $movieGenreRepo;
    }

    public function create_moviegenre(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "genre" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(["code" => 3, 'error' => $validator->errors()], 401);
            }

            $create_genre = $this->movieGenreRepo->create_moviegenre($validator->validated());

            return response(["code" => "1", "message" => "movie genre created successfully"]);

        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

    public function get_all_moviegenres()
    {
        try {
            $movie_genre = $this->movieGenreRepo->get_all_moviegenres();
            return response(["code" => 1, "data" => $movie_genre]);
        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }
    }

    public function update_movie_genre(Request $request, $id)
    {
        try {
            $movie_genre = $this->movieGenreRepo->edit_moviegenre($request, $id);
            return response(["code" => 1, "message" => "update successful"]);
        } catch (\Throwable$th) {
            return response(["code" => 3, "error" => $th->getMessage()]);
        }

    }
}
