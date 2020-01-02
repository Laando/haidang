<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DestinationPoint;

class Region extends Model {

    protected $table = 'regions';

    public function sourcepoints()
    {
        return $this->hasMany('App\Models\SourcePoint');
    }
    public function destinationpoints()
    {
        return $this->hasMany('App\Models\DestinationPoint');
    }
}
