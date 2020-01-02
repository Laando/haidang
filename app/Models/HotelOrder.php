<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelOrder extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Models\User','customer_id');
    }
    public function staff()
    {
        return $this->belongsTo('App\Models\User','staff_id');
    }
    public function hotelstaff()
    {
        return $this->belongsTo('App\Models\User','tourstaff_id');
    }
    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel','hotel_id');
    }
    public function roomorders()
    {
        return $this->hasMany('App\Models\RoomOrder','hotelorder_id');
    }
}
