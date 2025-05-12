<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'firebase_uid';
    public $incrementing = false; // Khóa chính không tự tăng
    protected $keyType = 'string'; // Khóa chính là chuỗi
    protected $fillable = ['firebase_uid', 'email', 'name', 'provider', 'role', 'fcm_token'];

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'firebase_uid', 'firebase_uid');
    }

    public function favoriteMovies()
    {
        return $this->hasMany(Favorite::class, 'firebase_uid', 'firebase_uid');
    }

    public function watchHistory()
    {
        return $this->hasMany(History::class, 'firebase_uid', 'firebase_uid');
    }
}
