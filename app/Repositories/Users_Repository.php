<?php

namespace App\Repositories;

use App\Models\Users;
use Illuminate\Database\Eloquent\Collection;

class Users_Repository
{
    protected $model;

    public function __construct(Users $users)
    {
        $this->model = $users;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(string $firebase_uid, array $data): bool
    {
        return $this->model->where('firebase_uid', $firebase_uid)->update($data);
    }

    public function delete(string $firebase_uid): bool
    {
        return $this->model->where('firebase_uid', $firebase_uid)->delete();
    }

    public function findByName(string $name): Users
    {
        return $this->model->where('name', 'like', '%' . $name . '%')->first();
    }

    public function findById(string $firebase_uid): Users
    {
        return $this->model->where('firebase_uid', $firebase_uid)->first();
    }
}
