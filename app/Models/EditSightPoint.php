<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditSightPoint extends Model {

    protected $table = 'edit_sight_points';
    public function sightpoints()
    {
        return $this->belongsTo('App\Models\SightPoint','sightpoint_id');
    }
    public function edittour()
    {
        return $this->belongsTo('App\Models\EditTour','touredit_id');
    }
}
