<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';
    protected $primaryKey = 'history_id';
    protected $fillable = [
        'firebase_uid',
        'movie_id',
        'watched_at',
        'progress',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(Users::class, 'firebase_uid', 'firebase_uid');
    }

    // Quan hệ với Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }
}
