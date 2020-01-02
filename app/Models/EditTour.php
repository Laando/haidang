<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditTour extends Model {

    protected $table = 'edit_tours';
    public function customer()
    {
        return $this->belongsTo('App\Models\User','customer_id');
    }
    public function sourcepoint()
    {
        return $this->belongsTo('App\Models\SourcePoint','sourcepoint_id');
    }
    public function destinationpoint()
    {
        return $this->belongsTo('App\Models\DestinationPoint','destinationpoint_id');
    }
    public function transport()
    {
        return $this->belongsTo('App\Models\EditTransport','transport_id');
    }
    public function editdaytours()
    {
        return $this->hasMany('App\Models\EditDayTour','edittour_id');
    }
    public function editsightpoints()
    {
        return $this->hasMany('App\Models\EditSightPoint','touredit_id');
    }

}
