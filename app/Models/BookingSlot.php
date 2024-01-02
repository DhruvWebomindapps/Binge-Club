<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'slot_id',
        'slot_name',
        'amount',
        'additional_amount',
        'start_time',
        'end_time',
        'event_id',
    ];
}
