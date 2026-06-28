<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'city',
        'country',
        'building',
        'floor',
        'apartment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
