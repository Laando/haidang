<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model {

    protected $table = 'restaurant_meals';
    public function destinationpoint()
    {
        return $this->belongsTo('App\Models\DestinationPoint','destination_point');
    }
    public function editdaytours()
    {
        return $this->hasMany('App\Models\EditDayTour');
    }
}
