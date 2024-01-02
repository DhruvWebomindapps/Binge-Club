<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'state_id',
        'name',
        'status',
        'priority',
    ];

    protected $caste = [
        'status'    => 'boolean'
    ];

    protected $with = [
        'locations'
    ];

    public function getState()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class)->where('status',1);
    }
}
