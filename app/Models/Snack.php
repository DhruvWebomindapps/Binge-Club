<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snack extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'location_id',
        'icon',
        'title',
        'price',
        'status',
        'priority',
    ];

    public function getCity()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function getLocation()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
}
