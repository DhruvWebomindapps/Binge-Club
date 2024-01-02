<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenFeature extends Model
{
    use HasFactory;
    protected $fillable = [
        'screen_id',
        'title'
    ];
}
