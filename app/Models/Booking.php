<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'city_id',
        'location_id',
        'screen_id',
        'book_date',
        'time_slot_id',
        'package_id',
        'name',
        'phone',
        'email',
        'nick_name',
        'partner_name',
        'time_slot',
        'time_slot_amount',
        'additional_amount',
        'package_title',
        'package_price',
        'total_amount',
        'gst_amount',
        'grand_total_amount',
        'package_amount',
        'package_dicount_percent',
        'package_dicount_amount',
        'package_discount_start_date',
        'package_dicount_end_date',
        'with_decoration',
        'number_of_people',
        'status',
        'city_name',
        'location_name',
        'screen_capacity',
        'screen_name',
        'time_slot_name',
        'is_online_booking',
        'booking_status',

        'payment_type',
        'advance',
        'balance',
        'notes'
    ];


    protected $with = [
        'slots',
        'items'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCity()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function getLocation()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function getScreen()
    {
        return $this->hasOne(Screen::class, 'id', 'screen_id');
    }

    public function getTimeSlot()
    {
        return $this->hasMany(Booking::class, 'time_slot_id', 'id');
    }
    public function getPackageImage()
    {
        return $this->hasMany(PackageImage::class, 'package_id', 'package_id');
    }
    public function slots(): HasMany
    {
        return $this->hasMany(BookingSlot::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BookingItem::class);
    }
}
