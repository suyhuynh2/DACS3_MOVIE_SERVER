<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\API\Movie_API;
use App\Http\Controllers\API\Genres_API;
use App\Http\Controllers\API\Users_API;
use App\Http\Controllers\API\Favorite_API;


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

// Users
Route::post('/users', [Users_API::class, 'createUser'])->name('users.create');
Route::put('/users/{firebase_uid}', [Users_API::class, 'updateUser'])->name('users.update');

//Favorite
Route::post('/add-favorite', [Favorite_API::class, 'createFavorite'])->name('favorite.create');
Route::get('/check-favorite/{firebase_uid}/{movie_id}', [Favorite_API::class, 'checkFavorite'])->name('favorite.check');
Route::post('/remove-favorite', [Favorite_API::class, 'removeFavorite'])->name('favorite.remove');
Route::get('get-favorite/{firebase_uid}', [Favorite_API::class, 'getFavoritesByUser'])->name('favorite.get');
