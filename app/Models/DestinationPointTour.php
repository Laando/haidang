<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationPointTour extends Model {

    protected $table = 'destinationpoint_tour';
    
    public function tours(){
        return $this->belongsToMany('App\Models\Tour');
    }

}
