<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditHotel extends Model {

    protected $table = 'edit_hotels';
    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }
    public function editdaytour()
    {
        return $this->belongsTo('App\Models\EditDayTour','editdaytour_id');
    }
}
