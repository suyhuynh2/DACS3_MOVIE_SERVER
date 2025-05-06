<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $primaryKey = 'rating_id';
    protected $fillable = ['movie_id', 'firebase_uid', 'score', 'comment'];

    protected $appends = ['username'];
    protected $hidden = ['user'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }
    public function user()
    {
        return $this->belongsTo(Users::class, 'firebase_uid', 'firebase_uid');
    }

    public function getUsernameAttribute()
    {
        return $this->user?->name ?? 'Ẩn danh';
    }
}
