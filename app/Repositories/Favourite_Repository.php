<?php

namespace App\Repositories;

use App\Models\Favorite;

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

    public function getFavoritesByUserId(string $firebase_uid): array
    {
        return $this->model->where('firebase_uid', $firebase_uid)->with('movie')->get()->toArray();
    }
}
