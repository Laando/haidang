<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationPoint extends Model {

    protected $table = 'destination_points';
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }
    public function tours()
    {
        return $this->belongsToMany('App\Models\Tour','destinationpoint_tour','destinationpoint_id','tour_id')->withTimestamps();
    }
    public function blogs()
    {
        return $this->hasMany('App\Models\Blog','destinationpoint_id');
    }
    public function hotels()
    {
        return $this->hasMany('App\Models\Hotel','destinationpoint_id');
    }
    public function meals()
    {
        return $this->hasMany('App\Models\Meal','destination_point');
    }

}
