<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorite';
    protected $primaryKey = 'favorite_id';
    protected $fillable = ['movie_id', 'firebase_uid'];
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }
    public function user()
    {
        return $this->belongsTo(Users::class, 'firebase_uid', 'firebase_uid');
    }
}
