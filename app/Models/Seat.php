<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model {

    protected $table = 'seats';
    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }
    public function transport()
    {
        return $this->belongsTo('App\Models\Transport');
    }
}
