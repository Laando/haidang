<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

    protected $table = 'consults';
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function tour()
    {
        return $this->belongsTo('App\Models\Tour','tour_id');
    }
    public function checkStaff() {
        return $this->belongsTo('App\Models\User','staff_id');
    }
}
