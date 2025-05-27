<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Movie_API;
use App\Http\Controllers\API\Genres_API;
use App\Http\Controllers\API\Users_API;
use App\Http\Controllers\API\Favorite_API;
use App\Http\Controllers\API\Rating_API;
use App\Http\Controllers\API\History_API;

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

//Rating
Route::post('/add-rating', [Rating_API::class, 'createRating'])->name('rating.create');
Route::get('/all-rating/{movie_id}', [Rating_API::class, 'all_rating_api'])->name('rating.all');

//History
Route::post('/add-history', [History_API::class, 'store'])->name('history.create');
Route::get('/get-history/{firebase_uid}', [History_API::class, 'getHistoryByUser'])->name('history.get');
Route::get('/check-history/{firebase_uid}/{movie_id}', [History_API::class, 'checkHistory'])->name('history.check');
Route::get('/get-info-history/{firebase_uid}/{movie_id}', [History_API::class, 'getInfoHistory'])->name('history.getInfoHistory');
