<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {

	public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function tour()
    {
        return $this->belongsTo('App\Models\Tour','tour_id');
    }

}
