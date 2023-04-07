<?php

namespace App\Http\Controllers\Movies;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\interfaces\MovieRepositoryInterface;

class MoviesController extends Controller
{

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
                return response()->json(["code" => 3, 'error' => $validator->errors()], 401);
            }



        } catch (\Throwable$th) {
            //throw $th;
        }
    }

    public function get_all_movies(Request $request)
    {

    }
}
