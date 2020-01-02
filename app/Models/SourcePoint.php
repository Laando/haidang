<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourcePoint extends Model {

    protected $table = 'source_points';


    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }
    public function tours()
    {
        return $this->hasMany('App\Models\Tour');
    }

}
