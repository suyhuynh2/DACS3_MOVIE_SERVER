<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\Movie;

class Favorite_Repository
{
    protected $model;

    public function __construct(Favorite $favorite)
    {
        $this->model = $favorite;
    }

    public function create(array $data): Favorite
    {
        return $this->model->create($data);
    }

    public function delete(int $favorite_id): bool
    {
        return $this->model->where('favorite_id', $favorite_id)->delete();
    }

    public function getFavoritesByUserId(string $firebase_uid)
    {
        return $this->model
            ->with(['movie.genres', 'movie.ratings', 'movie.favoredByUsers']) // Load đầy đủ quan hệ
            ->where('firebase_uid', $firebase_uid)
            ->get();
    }

    public function exists(string $firebase_uid, int $movie_id): bool
    {
        return $this->model->where('firebase_uid', $firebase_uid)
            ->where('movie_id', $movie_id)
            ->exists();
    }

    public function isFavorite(string $firebase_uid, int $movie_id): bool
    {
        return $this->model
            ->where('firebase_uid', $firebase_uid)
            ->where('movie_id', $movie_id)
            ->exists();
    }

    public function removeFavorite(string $firebase_uid, int $movie_id): bool
    {
        return $this->model
            ->where('firebase_uid', $firebase_uid)
            ->where('movie_id', $movie_id)
            ->delete();
    }

    public function findByUserAndMovie(string $firebase_uid, int $movie_id): ?Favorite
    {
        return $this->model
            ->where('firebase_uid', $firebase_uid)
            ->where('movie_id', $movie_id)
            ->first();
    }

    public function getMovieIdsByUserId(string $firebase_uid)
    {
        return $this->model
            ->where('firebase_uid', $firebase_uid)->get();
    }

    public function topByFavorites($limit = 5)
    {
        return Movie::withCount('favoredByUsers')
            ->orderByDesc('favored_by_users_count')
            ->limit($limit)
            ->get();
    }
}