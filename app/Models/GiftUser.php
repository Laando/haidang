<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class GiftUser extends Model {

    protected $table = 'gift_user';

    // guard attributes from mass-assignment
    public function customer()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function gift()
    {
        return $this->belongsTo('App\Models\Gift','gift_id');
    }
}
