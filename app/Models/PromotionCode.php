<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model {

    protected $table = 'promotion_codes';
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
    public function startdate()
    {
        return $this->belongsTo('App\Models\StartDate','startdate_id');
    }
}
