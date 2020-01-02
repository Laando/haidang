<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultiRoute extends Model {

    protected $table = 'multi_routes';
    public function multiroutepoints()
    {
        return $this->hasMany('App\Models\MultiRoutePoint','multiroute_id');
    }
    public function edittransports()
    {
        return $this->hasMany('App\Models\EditTransport','multiroute_id');
    }
}
