<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    public $timestamps = false;
    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel','hotel_id');
    }
    public function room()
    {
        return $this->hasMany('App\Models\Room','room_id');
    }
}
