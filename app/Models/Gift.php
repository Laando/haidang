<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model {

    public function users()
    {
        return $this->belongsToMany('App\Models\User','gift_user','gift_id','user_id')->withPivot(['amount','expire']);
    }

}
