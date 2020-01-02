<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model {

    protected $table = 'details';

    public function tour()
    {
        return $this->belongsTo('App\Models\Tour');
    }
}
