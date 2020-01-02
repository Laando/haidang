<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberType extends Model {

    protected $table = 'member_types';
    public function users()
    {
        return $this->hasMany('App\Models\Users','member_card_type');
    }
}
