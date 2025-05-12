<?php

namespace App\Repositories;

use App\Models\History;

class History_Repository
{
    protected $model;

    public function __construct(History $history)
    {
        $this->model = $history;
    }

    public function create(array $data): History
    {
        return $this->model->create($data);
    }

    public function getByUser(string $firebase_uid)
    {
        return $this->model->where('firebase_uid', $firebase_uid)->orderByDesc('watched_at')->get();
    }

    public function updateProgress(string $firebase_uid, int $movie_id, string $progress)
    {
        return $this->model->where('firebase_uid', $firebase_uid)
            ->where('movie_id', $movie_id)
            ->update([
                'progress' => $progress,
                'watched_at' => now(),
            ]);
    }

    public function exists(string $firebase_uid, int $movie_id): bool
    {
        return $this->model
            ->where('firebase_uid', $firebase_uid)
            ->where('movie_id', $movie_id)
            ->exists();
    }

    public function getByUserAndMovie(string $firebase_uid, int $movie_id): ?History
    {
        return $this->model
            ->where('firebase_uid', $firebase_uid)
            ->where('movie_id', $movie_id)
            ->first();
    }
}
