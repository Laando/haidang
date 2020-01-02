<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelType extends Model
{
    public $timestamps = false;
    public function hotelcharacters ()
    {
        return $this->hasMany('App\Models\HotelCharacter','type_id');
    }
    public function hotels ()
    {
        return $this->belongsToMany('App\Models\Hotel','hotel_hotel_type','hoteltype_id','hotel_id')->withTimestamps();
    }
}
