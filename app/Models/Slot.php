<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'slotable_id',
        'slotable_type',
        'start_time',
        'end_time',
        'amount',
        'additional_amount'
    ];


    public function slotable(): MorphTo
    {
        return $this->morphTo();
    }
}
