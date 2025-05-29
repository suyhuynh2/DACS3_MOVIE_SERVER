<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = ['firebase_uid', 'amount', 'content', 'status', 'order_code'];

    public function user()
    {
        return $this->belongsTo(Users::class, 'firebase_uid', 'firebase_uid');
    }
}
