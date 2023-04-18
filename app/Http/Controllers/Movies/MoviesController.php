<?php

namespace App\Http\Controllers\Movies;

use Validator;
use Illuminate\Http\Request;
use App\Custom\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\interfaces\MovieRepositoryInterface;

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
                "genre" => "required",
                "details" => [],
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors(), 401);
            }

        } catch (\Throwable$th) {
            //throw $th;
        }
    }

    public function get_all_movies()
    {
      try {

      } catch (\Throwable $th) {
        //throw $th;
      }
    }

    public function get_single_movie($id)
    {

    }

    public function edit_movie(Request $request, $id)
    {

    }

    public function delete_movie($id)
    {

    }
}
