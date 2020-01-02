<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddingCate extends Model {

    protected $table = 'adding_cates';
    public function addings()
    {
        return $this->hasMany('App\Models\Adding');
    }

}
