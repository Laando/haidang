<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartDate extends Model {

    protected $table = 'start_dates';

    public function tour()
    {
        return $this->belongsTo('App\Models\Tour');
    }
    public function traffic() {
        return $this->hasOne('App\Models\Traffic','idtypeVehicle','traffic');
    }
    public function transports()
    {
        return $this->hasMany('App\Models\Transport','startdate_id');
    }
//    public function addings()
//    {
//        return $this->hasMany('App\Models\Adding','startdate_id');
//    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order','startdate_id');
    }
    public function promotion_codes()
    {
        return $this->hasMany('App\Models\PromotionCode','startdate_id');
    }
    public function countPromotionCode(){
        $count= PromotionCode::where('startdate_id','=',$this->id)->whereNull('order_id')->count();
        return $count;
    }
    protected $casts = [
        'addings' => 'array'
    ];
}
