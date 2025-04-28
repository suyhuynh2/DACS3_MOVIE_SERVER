<?php

namespace App\Repositories;

use App\Models\Genres;
use Illuminate\Database\Eloquent\Collection;

class Genres_Repository
{
    protected $model;

    public function __construct(Genres $genres)
    {
        $this->model = $genres;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Genres
    {
        return $this->model->create($data);
    }

    public function update(int $genres_id, array $data): bool
    {
        return $this->model->where('genres_id', $genres_id)->update($data);
    }

    public function delete(int $genres_id): bool
    {
        return $this->model->where('genres_id', $genres_id)->delete();
    }

    public function findByName(string $name): ?Genres
    {
        return $this->model->where('name', 'like', '%' . $name . '%')->first();
    }

    public function findById(int $genres_id): ?Genres
    {
        return $this->model->find($genres_id);
    }

    public function paginate($perPage)
    {
        return $this->model->paginate($perPage);
    }
}
