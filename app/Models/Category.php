<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'type',
        'name',
        'icon'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
