<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelBook extends Model {

    protected $table = 'hotel_books';
    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room','room_books','hotelbook_id','room_id')->withPivot('number','cached_price');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\User','customer_id');
    }
    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel','hotel_id');
    }
}
