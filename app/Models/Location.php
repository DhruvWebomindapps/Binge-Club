<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'state_id',
        'city_id',
        'name',
        'admin_name',
        'admin_phone',
        'admin_email',
        'icon_img',
        'address',
        'landmark',
        'pincode',
        'status',
        'priority'
    ];

    protected $caste = [
        'status' => 'boolean'
    ];

    protected $with = [
        'screens',
        'occasions',
        'cakes',
        'decorations',
        'gifts',
        'snacks',
        'bouquets',
        'others'
    ];

    function getState()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    function getCity()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    public function screens(): HasMany
    {
        return $this->hasMany(Screen::class)->where('status', true);
    }

    public function occasions(): HasMany
    {
        return $this->hasMany(Package::class, 'location_id')->where('status', true)->orderBy('priority', 'asc');
    }
    public function cakes(): HasMany
    {
        return $this->hasMany(Cake::class, 'location_id')->where('status', true)->orderBy('priority', 'asc');
    }

    public function decorations(): HasMany
    {
        return $this->hasMany(Decoration::class, 'location_id')->where('status', true)->orderBy('priority', 'asc');
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(Gift::class, 'location_id')->where('status', true)->orderBy('priority', 'asc');
    }
    public function snacks(): HasMany
    {
        return $this->hasMany(Snack::class, 'location_id')->where('status', true)->orderBy('priority', 'asc');
    }
    public function bouquets(): HasMany
    {
        return $this->hasMany(Bouquet::class, 'location_id')->where('status', true)->orderBy('priority', 'asc');
    }
    public function others(): HasMany
    {
        return $this->hasMany(Other::class, 'location_id')->where('status', true)->orderBy('priority', 'asc');
    }
}
