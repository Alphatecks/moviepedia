<?php

namespace App\Http\Controllers\Movies;

use App\Custom\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\interfaces\MovieRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class MoviesController extends Controller
{

    use ApiResponseTrait;

    private $movieRepo;

    public function __construct(MovieRepositoryInterface $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    public function create_movies(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "movie_name" => "required",
                "genre_id" => "required",
                "details" => [],
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

            $movie = $this->movieRepo->create_movie($request->all());
            return $this->success("Movie created successfully");
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function get_all_movies()
    {
        try {
            $movie = $this->movieRepo->get_all_movies();
            return $this->success("Movie fetched successfully", $movie);
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function get_single_movie($id)
    {
        try {
            $movie = $this->movieRepo->get_single_movie($id);
            return $this->success("Movie fetched successfully", $movie);
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function edit_movie(Request $request, $id)
    {
        try {
            $movie = $this->movieRepo->update_movie($request->all(), $id);
            return $this->success("Movie updated successfully");
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }

    public function delete_movie($id)
    {
        try {
            $this->movieRepo->delete_movie($id);
            return $this->success('Movie deleted successfully');
        } catch (\Throwable$th) {
            return $this->error($th->getMessage(), 400);
        }
    }
}
