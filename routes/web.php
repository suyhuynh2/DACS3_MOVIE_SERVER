<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Genres_Controller;
use App\Http\Controllers\Admin\Movie_Controller;
use App\Http\Controllers\Admin\Users_Controller;
use App\Http\Controllers\Admin\Dashboard_Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Dashboard_Controller::class, 'index']);






//Genres

Route::get('add-genres-ui', function () {
    return view('genres.add_genres');
})->name('add-genres-ui');
Route::get('/all-genres-ui', [Genres_Controller::class, 'all_genres_ui'])->name('all-genres-ui');
Route::post('/save-genres', [Genres_Controller::class, 'save_genres'])->name('save-genres');
Route::get('/edit-genres/{genres_id}', [Genres_Controller::class, 'edit_genres'])->name('edit-genres');
Route::post('/update-genres/{genres_id}', [Genres_Controller::class, 'update_genres'])->name('update-genres');
Route::post('/delete-genres/{genres_id}', [Genres_Controller::class, 'delete_genres'])->name('delete-genres');


//Movie
Route::get('/add-movie-ui', [Movie_Controller::class, 'add_movie_ui'])->name('add-movie-ui');
Route::post('/save-movie', [Movie_Controller::class, 'save_movie'])->name('save-movie');
Route::get('/all-movie-ui', [Movie_Controller::class, 'all_movie_ui'])->name('all-movie-ui');
Route::get('/edit-movie-ui/{movie_id}', [Movie_Controller::class, 'edit_movie_ui'])->name('edit-movie-ui');
Route::post('/update-movie/{movie_id}', [Movie_Controller::class, 'update_movie'])->name('update-movie');
Route::post('/delete-movie/{movie_id}', [Movie_Controller::class, 'delete_movie'])->name('delete-movie');

//users

Route::get('/all-users-ui', [Users_Controller::class, 'all_users_ui'])->name('all-users-ui');
Route::post('/save-user', [Users_Controller::class, 'save_user'])->name('save-user');
Route::get('/edit-user-ui/{firebase_uid}', [Users_Controller::class, 'edit_user_ui'])->name('edit-user-ui');
Route::post('/update-user/{firebase_uid}', [Users_Controller::class, 'update_user'])->name('update-user');
Route::post('/delete-user/{firebase_uid}', [Users_Controller::class, 'delete_user'])->name('delete-user');
