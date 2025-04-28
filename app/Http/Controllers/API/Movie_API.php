<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Movie_Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Movie_API extends Controller
{
    protected $movieRepository;

    public function __construct(Movie_Repository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function all_movie_api(): JsonResponse
    {
        $movies = $this->movieRepository->all();
        return response()->json($movies);
    }
}
