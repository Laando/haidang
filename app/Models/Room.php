<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false;
    public function hotel ()
    {
        return $this->belongsTo('App\Models\Hotel','hotel_id');
    }
    public function images()
    {
        return $this->hasMany('App\Models\HotelImage','room_id');
    }
    public function edithotels()
    {
        return $this->hasMany('App\Models\EditHotel');
    }
}
