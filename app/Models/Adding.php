<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adding extends Model {

    protected $table = 'addings';
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order','adding_order','adding_id','order_id');
    }
    public function startdate()
    {
        return $this->belongsTo('App\Models\StartDate');
    }
    public function addingcate()
    {
        return $this->belongsTo('App\Models\AddingCate');
    }
}
