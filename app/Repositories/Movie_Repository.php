<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

class Movie_Repository
{

    protected $model;

    public function __construct(Movie $movie)
    {
        $this->model = $movie;
    }

    public function all(): Collection
    {
        return $this->model
            ->with(['genres', 'ratings.user'])
            ->get()
            ->makeHidden(['favoredByUsers']);
    }


    public function create(array $data): Movie
    {
        return $this->model->create($data);
    }

    public function update(int $movie_id, array $data): bool
    {
        return $this->model->where('movie_id', $movie_id)->update($data);
    }

    public function delete(int $movie_id): bool
    {
        return $this->model->where('movie_id', $movie_id)->delete();
    }

    public function findByName(string $name): ?Movie
    {
        return $this->model->where('name', 'like', '%' . $name . '%')->first();
    }

    public function findById(int $movie_id): ?Movie
    {
        return $this->model->with('genres')
            ->find($movie_id)
            ?->makeHidden(['ratings', 'favoredByUsers']);
    }

    public function paginate($perPage)
    {
        return $this->model->paginate($perPage);
    }
}
