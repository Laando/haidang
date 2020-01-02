<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiRoutePoint extends Model {

    protected $table = 'multi_route_points';
    public function destinationpoint()
    {
        return $this->belongsTo('App\Models\DestinationPoint','destinationpoint_id');
    }
    public function multi_route()
    {
        return $this->belongsTo('App\Models\MultiRoute','multiroute_id');
    }
}
