<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movie';
    protected $primaryKey = 'movie_id';

    protected $fillable = [
        'title',
        'actors',
        'description',
        'trailer_url',
        'poster_url',
        'video_url',
        'release_year',
        'duration',
        'country',
        'views',
        'status',
    ];

    protected $appends = ['averageRating'];

    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'genre_movie', 'movie_id', 'genres_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'movie_id', 'movie_id');
    }

    public function favoredByUsers()
    {
        return $this->hasMany(Favorite::class, 'movie_id', 'movie_id');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('score');
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->ratings()->avg('score') ?? 0, 1);
    }

    public function watchHistory()
    {
        return $this->hasMany(History::class, 'movie_id', 'movie_id');
    }
}
