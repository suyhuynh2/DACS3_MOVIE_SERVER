<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\API\Movie_API;
use App\Http\Controllers\API\Genres_API;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//movie
Route::get('/movies-all', [Movie_API::class, 'all_movie_api'])->name('movies-all');

//genres
Route::get('/genres-all', [Genres_API::class, 'all_genres_api'])->name('genres-all');
