<?php

namespace App\Repositories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Collection;

class Rating_Repository
{
    protected $model;

    public function __construct(Rating $rating)
    {
        $this->model = $rating;
    }

    public function create(array $data): Rating
    {
        return $this->model->create($data);
    }

    public function update(int $rating_id, array $data): bool
    {
        return $this->model->where('rating_id', $rating_id)->update($data);
    }

    public function delete(int $rating_id): bool
    {
        return $this->model->where('rating_id', $rating_id)->delete();
    }

    public function getRatingsByMovieId(int $movie_id): Collection
    {
        return $this->model->where('movie_id', $movie_id)->with('user')->get();
    }

    public function getRatingsByUserId(string $firebase_uid): Collection
    {
        return $this->model->where('firebase_uid', $firebase_uid)->with('movie')->get();
    }
}
