<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model {

    protected $table = 'transports';
    public function startdate()
    {
        return $this->belongsTo('App\Models\StartDate','startdate_id');
    }
    public function seats()
    {
        return $this->hasMany('App\Models\Seat');
    }
    public function countNullSeats()
    {
        return $this->seats()->where('order_id','=',null)->count();
    }
    public function countOrderSeats()
    {
        return $this->seats()->whereNotNull('order_id')->count();
    }
}
