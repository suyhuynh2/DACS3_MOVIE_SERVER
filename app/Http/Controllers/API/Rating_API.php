<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Rating_Repository;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Events\MovieUpdate;

class Rating_API extends Controller
{
    protected $ratingRepository;

    public function __construct(Rating_Repository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
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

        $movie = Movie::find($data['movie_id']);
        event(new MovieUpdate($movie, 'update'));

        return response()->json($rating, 201);
    }
}