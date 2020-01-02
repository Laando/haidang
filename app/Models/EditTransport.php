<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditTransport extends Model {

    protected $table = 'edit_transports';
    public function multiroute()
    {
        return $this->belongsTo('App\Models\MultiRoute','multiroute_id');
    }
}
