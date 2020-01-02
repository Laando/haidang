<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'phone', 'gender', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    public function isAdmin()
    {
        return $this->role->slug == 'admin';
    }
    public function isStaff()
    {
        return $this->role->slug == 'staff';
    }
    public function isAgent()
    {
        return $this->role->slug == 'agent';
    }
    public function isNotUser()
    {
        return $this->role->slug != 'user';
    }
    public function tours()
    {
        return $this->hasMany('App\Models\Tour');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order','customer_id');
    }
    public function gifts()
    {
        return $this->belongsToMany('App\Models\Gift','gift_user','user_id','gift_id')->withPivot('amount','expire','created_at','updated_at');
    }
    public function totalseat()
    {
        $totalseat = 0;
        $orders = $this->orders()->where('status','>',1)->get();
        foreach($orders as $order){
            $totalseat += $order->adult + $order->addingseat;
        }
        return $totalseat;
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review','user_id');
    }
    public function membertype() {
        return $this->belongsTo('App\Models\MemberType', 'member_card_type');
    }

    public function staff_order(){
        return $this->hasMany('App\Models\Order','staff_id');
    }
}
