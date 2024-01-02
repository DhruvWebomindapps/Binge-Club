<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'location_id',
        'screen_id',
        'title',
        'slug',
        'description',
        'price',
        'discount_percent',
        'discount_price',
        'grand_total',
        'discount_s_date',
        'discount_e_date',
        'status',
        'priority',
    ];

    protected $caste = [
        'status' => 'boolean'
    ];

    protected $with = ['getPackageImage'];

    function getCity(){
        return $this->hasOne(City::class,'id','city_id');
    }
    function getLocation(){
        return $this->hasOne(Location::class,'id','location_id');
    }
    function getScreen(){
        return $this->hasOne(Screen::class,'id','screen_id');
    }
    function getPackageImage(){
        return $this->hasMany(PackageImage::class,'package_id','id');
    }
}
