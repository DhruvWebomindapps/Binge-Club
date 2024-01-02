<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'type',
        'type_id',
        'title',
        'discount_percentage',
        'discount_price',
        'price'
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
