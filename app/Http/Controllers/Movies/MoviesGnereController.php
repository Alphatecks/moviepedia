<?php

namespace App\Http\Controllers\Movies;

use App\Custom\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\interfaces\MovieGenreRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class MoviesGnereController extends Controller
{

    use ApiResponseTrait;

    private $movieGenreRepo;
    public function __construct(MovieGenreRepositoryInterface $movieGenreRepo)
    {
        $this->movieGenreRepo = $movieGenreRepo;
    }

    public function create_moviegenre(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "genre" => "required|unique:movie_genres",
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

            $create_genre = $this->movieGenreRepo->create_moviegenre($validator->validated());
            return $this->success("Genre created successfully");
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function get_all_moviegenres()
    {
        try {
            $movie_genre = $this->movieGenreRepo->get_all_moviegenres();
            return $this->success("Genre fetched successfully", $movie_genre);
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function update_movie_genre(Request $request, $id)
    {
        try {
            $movie_genre = $this->movieGenreRepo->update_movie_genre($request->all(), $id);
            return $this->success("Genre edited successfully");
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }

    }

    public function delete_movie_genre($id){
        try {
            $movie_genre = $this->movieGenreRepo->delete_movie_genre($id);
            return $this->success("Genre deleted successfully");
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400);
        }
    }
}
