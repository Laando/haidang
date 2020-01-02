<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $table = 'orders';
    public function startdate()
    {
        return $this->belongsTo('App\Models\StartDate','startdate_id');
    }
    public function startdate_kh()
    {
        return $this->belongsTo('App\Models\StartDate','startdate_id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\User','customer_id');
    }
    public function staff()
    {
        return $this->belongsTo('App\Models\User','staff_id');
    }
    public function tourstaff()
    {
        return $this->belongsTo('App\Models\User','tourstaff_id');
    }
    public function seats()
    {
        return $this->hasMany('App\Models\Seat');
    }
    public function addings()
    {
        return $this->belongsToMany('App\Models\Adding','adding_order','order_id','adding_id');
    }
    public function promotion_codes()
    {
        return $this->hasMany('App\Models\PromotionCode','order_id');
    }
}
