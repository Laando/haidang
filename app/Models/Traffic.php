<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model {

    protected $table = 'typevehicle';

    public function startdates() {
        return $this->hasMany('App\Models\StartDate','traffic','idtypeVehicle');
    }
}
