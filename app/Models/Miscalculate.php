<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Miscalculate extends Model {

    protected $table = 'miscalculates';
    public function stardates()
    {
        return $this->belongsToMany('App\Models\StartDate','miscalculate_amounts','miscalculate_id','startdate_id')->withPivot('amount');
    }
}
