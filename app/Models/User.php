<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword , HasApiTokens, Notifiable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	//public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username','email','password','fullname','fullnameen','phone','dob','address','gender','lastlogin','yahoo','skype','facebook','getmail','role_id','status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	// disable remember_token
    /*
	protected $hidden = ['password', 'remember_token'];
		public function getRememberToken()
		{
	   return null; // not supported
	}

	public function setRememberToken($value)
	{
	   // not supported
	}

	public function getRememberTokenName()
	{
	   return null; // not supported
	}

	 /**
	  * Overrides the method to ignore the remember token.

	 public function setAttribute($key, $value)
	 {
	 	$isRememberTokenAttribute = $key == $this->getRememberTokenName();
	 	if (!$isRememberTokenAttribute)
	 	{
	 		parent::setAttribute($key, $value);
	 	}
	 }
      *
      * */
	 // end disable remember_token
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
    public function isAccountant()
    {
        return $this->role->slug == 'accountant' || $this->role->slug == 'chiefaccountant' ;
    }
    public function isChiefAccountant()
    {
        return $this->role->slug == 'chiefaccountant' ;
    }
    public function isOperator()
    {
        return $this->role->slug == 'operator';
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
            $totalseat += $order->adult + $order->childList;
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
}
