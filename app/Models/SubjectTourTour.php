<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class SubjectTourTour extends Model {

    protected $table = 'subjecttour_tour';

    // guard attributes from mass-assignment
    public function tours(){
        return $this->belongsToMany('App\Models\Tour')->withTimestamps();
    }
}
