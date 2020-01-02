<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditDayTour extends Model {

    protected $table = 'edit_day_tours';
    public function edittour()
    {
        return $this->belongsTo('App\Models\EditTour','edittour_id');
    }
    public function meal()
    {
        return $this->belongsTo('App\Models\Meal');
    }
    public function edithotels()
    {
        return $this->hasMany('App\Models\EditHotel','editdaytour_id');
    }
}
