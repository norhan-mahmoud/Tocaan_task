<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
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
