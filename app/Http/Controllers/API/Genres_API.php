<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Genres_Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Genres_API extends Controller
{
    protected $genresRepository;

    public function __construct(Genres_Repository $genresRepository)
    {
        $this->genresRepository = $genresRepository;
    }

    public function all_genres_api(): JsonResponse
    {
        $genres = $this->genresRepository->all();
        return response()->json($genres);
    }
}
