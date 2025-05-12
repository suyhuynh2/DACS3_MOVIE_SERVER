<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Rating_Repository;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Events\MovieUpdate;
use App\Repositories\Movie_Repository;

class Rating_API extends Controller
{
    protected $ratingRepository;
    protected $movieRepository;

    public function __construct(Rating_Repository $ratingRepository, Movie_Repository $movieRepository)
    {
        $this->ratingRepository = $ratingRepository;
        $this->movieRepository = $movieRepository;
    }


    public function all_rating_api($movie_id)
    {
        $ratings = $this->ratingRepository->getRatingsByMovieId($movie_id);
        return response()->json($ratings);
    }


    public function createRating(Request $request)
    {
        $data = $request->all();
        $rating = $this->ratingRepository->create($data);

        $movie = $this->movieRepository->findById($data['movie_id']);
        event(new MovieUpdate($movie, 'update'));

        return response()->json($rating, 201);
    }
}
