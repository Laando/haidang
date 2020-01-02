<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public function rooms ()
    {
        return $this->hasMany('App\Models\Room','hotel_id');
    }
    public function hoteltypes ()
    {
        return $this->belongsToMany('App\Models\HotelType','hotel_hotel_type','hotel_id','hoteltype_id')->withTimestamps();
    }
    public function hotelcharacters ()
    {
        return $this->belongsToMany('App\Models\HotelCharacter','hotel_hotel_character','hotel_id','hotelcharacter_id')->withTimestamps();
    }
    public function destinationpoint()
    {
        return $this->belongsTo('App\Models\DestinationPoint','destinationpoint_id');
    }
    public function images()
    {
        return $this->hasMany('App\Models\HotelImage','hotel_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
