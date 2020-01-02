<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SightPoint extends Model {

    protected $table = 'sight_points';

    public function destinationpoint()
    {
        return $this->belongsTo('App\Models\DestinationPoint');
    }
    public function tours()
    {
        return $this->belongsToMany('App\Models\Tours','sightpoint_tour','sightpoint_id','tour_id')->withTimestamps();
    }
    public function tourtickets()
    {
        return $this->belongsToMany('App\Models\Tours','sightpointitcket_tour','sightpoint_id','tour_id')->withTimestamps();
    }
    public function editsightpoints()
    {
        return $this->hasMany('App\Models\EditSightPoint','sightpoint_id');
    }
}
