<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'city',
        'state',
        'airport'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
