<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'name',
        'icon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
