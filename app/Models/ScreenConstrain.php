<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ScreenConstrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_id',
        'date',
        'status'
    ];

    protected $with = [
        'slots',
    ];

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class);
    }


    public function slots(): MorphMany
    {
        return $this->morphMany(Slot::class, 'slotable');
    }
}
