<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screen extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'state_id',
        'city_id',
        'location_id',
        'screen_name',
        'admin_name',
        'admin_phone',
        'admin_email',
        'capacity',
        'max_people',
        'address',
        'description',
        'status',
        'priority',
        'calendar_id',
    ];

    protected $caste = [
        'status'    => 'boolean'
    ];

    protected $with = [
        'days',
        'constraints'
    ];

    function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function getTimeSlot()
    {
        return $this->hasMany(Timeslot::class, 'screen_id');
    }

    function getScreenImages()
    {
        return $this->hasMany(ScreenImage::class, 'screen_id');
    }

    function getLocation()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
    function getFeatures()
    {
        return $this->hasMany(ScreenFeature::class, 'screen_id');
    }


    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }


    public function days(): HasMany
    {
        return $this->hasMany(ScreenDay::class);
    }

    public function constraints(): HasMany
    {
        return $this->hasMany(ScreenConstrain::class);
    }
}
