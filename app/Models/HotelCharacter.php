<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelCharacter extends Model
{
    public $timestamps = false;
    public function hoteltype ()
    {
        return $this->belongsTo('App\Models\HotelType','type_id');
    }
    public function hotels ()
    {
        return $this->belongsToMany('App\Models\Hotel','hotel_hotel_character','hotelcharacter_id','hotel_id')->withTimestamps();
    }
}
