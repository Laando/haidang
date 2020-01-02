<?php namespace App\Repositories;

use App\Models\MemberType;
use App\Models\User, App\Models\Role;
use File, Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserRepository extends BaseRepository{

	/**
	 * The Role instance.
	 *
	 * @var App\Models\Role
	 */	
	protected $role;

	/**
	 * Create a new UserRepository instance.
	 *
   	 * @param  App\Models\User $user
	 * @param  App\Models\Role $role
	 * @return void
	 */
	public function __construct(
		User $user, 
		Role $role , MemberType $memberType )
	{
		$this->model = $user;
		$this->role = $role;
		$this->membertype = $memberType;
	}

	/**
	 * Save the User.
	 *
	 * @param  App\Models\User $user
	 * @param  Array  $inputs
	 * @return void
	 */
  	private function save($user, $inputs)
	{		
		if(isset($inputs['seen'])) 
		{
			$user->seen = $inputs['seen'] == 'true';		
		} else {
            if($inputs['username']!='') {
                $user->username = $inputs['username'];
            }
            if($inputs['email']!='') {
                $user->email = $inputs['email'];
            }
            $user->fullname = $inputs['fullname'];
            $user->fullnameen = khongdau($user->fullname);
            $user->phone = $inputs['phone'];
            $user->dob = Carbon::createFromFormat('d/m/Y',$inputs['dob']);
            $user->address = $inputs['address'];
            $user->gender = $inputs['gender'];
            $user->member_card = $inputs['member_card'];
            $user->member_card_type = $inputs['member_card_type'];
            $user->yahoo= $inputs['yahoo'];
            $user->skype = $inputs['skype'];
            $user->facebook = $inputs['facebook'];
            $user->getmail = isset($inputs['getmail'])?'1':'0';
            $user->status = isset($inputs['status'])?'1':'0';
			if(isset($inputs['role'])) {
				$user->role_id = $inputs['role'];	
			} else {
				$role_user = $this->role->where('slug', 'user')->first();
				$user->role_id = $role_user->id;
			}
		}

		$user->save();
	}

	/**
	 * Get users collection.
	 *
	 * @param  int  $n
	 * @param  string  $role
	 * @return Illuminate\Support\Collection
	 */
	public function index($n, $role ,$search)
	{
		if($role != 'total')
		{
			$users = $this->model
			->with('role')
			->whereHas('role', function($q) use($role) {
				$q->whereSlug($role);
			})		;
            if ($search!='')
            {
                $users  = $users->where('phone','like','%'.$search.'%')
                    ->orWhere('fullname','like','%'.$search.'%')
                    ->orWhere('member_card','like','%'.trim($search," ").'%');
            }
            return $users->oldest('seen')
			->latest()
			->paginate($n);			
		}

        $users = $this->model
		->with('role')	;
        //dd($users->where('phone','like','%'.$search.'%')->get());

        if ($search!='')
        {
            $users  = $users->where('phone','like','%'.$search.'%')->orWhere('fullname','like','%'.$search.'%');
        }
        //dd($users->get());
        return $users->oldest('seen')
		->latest()
		->paginate($n);
	}

	/**
	 * Count the users.
	 *
	 * @param  string  $role
	 * @return int
	 */
	public function count($role = null)
	{
		if($role)
		{
			return $this->model
			->whereHas('role', function($q) use($role) {
				$q->whereSlug($role);
			})->count();			
		}

		return $this->model->count();
	}

	/**
	 * Count the users.
	 *
	 * @param  string  $role
	 * @return int
	 */
	public function counts()
	{
		$counts = [
			'admin' => $this->count('admin'),
			'staff' => $this->count('staff'),
            'agent' => $this->count('agent'),
			'user' => $this->count('user'),
			'accountant' => $this->count('accountant'),
			'chiefaccountant' => $this->count('chiefaccountant'),
			'operator' => $this->count('operator')
		];

		$counts['total'] = array_sum($counts);

		return $counts;
	}

	/**
	 * Get a user collection.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function create()
	{
		$select = $this->role->all()->pluck('title', 'id');
		$select_card_type = $this->membertype->all()->pluck('name', 'id');
        $select_card_type->prepend('None');
		return compact('select','select_card_type');
	}

	/**
	 * Create a user.
	 *
	 * @param  array  $inputs
	 * @param  int    $user_id
	 * @return App\Models\User 
	 */
	public function store($inputs)
	{
		$user = new $this->model;

		$user->password = bcrypt($inputs['password']);

		$this->save($user, $inputs);

		return $user;
	}

	/**
	 * Get user collection.
	 *
	 * @param  string  $slug
	 * @return Illuminate\Support\Collection
	 */
	public function show($id)
	{
		$user = $this->model->with('role')->findOrFail($id);

		return compact('user');
	}

	/**
	 * Get user collection.
	 *
	 * @param  int  $id
	 * @return Illuminate\Support\Collection
	 */
	public function edit($id)
	{
		$user = $this->getById($id);

		$select = $this->role->all()->pluck('title', 'id');
        $select_card_type = $this->membertype->all()->pluck('name', 'id');
        $select_card_type->prepend('None');
		return compact('user', 'select' , 'select_card_type');
	}

	/**
	 * Update a user.
	 *
	 * @param  array  $inputs
	 * @param  int    $id
	 * @return void
	 */
	public function update($inputs, $id)
	{
		$user = $this->getById($id);
        //$user->fullnameen = khongdau($inputs['fullname']);
        if(!($user->role->slug== 'admin' || $user->role->slug== 'staff'))  {
            $this->save($user, $inputs);
        } else {
            $current_user  = Auth::user();
            $role = $current_user->role->slug;
            if($role=='admin')  {
                if(isset($inputs['avatar'])){
                    $avatar = $inputs['avatar'] ;
                    $old_avatar = $inputs['old-avatar'] ;
                    if($old_avatar!= '') {
                        if(File::exists(public_path().'\image\avatar\\'.$old_avatar))
                        {
                            File::delete(public_path().'\image\avatar\\'.$old_avatar);
                        }
                    }
                    $file = Input::file('avatar');
                    $filename = substr(md5($user->username),0,15).$file->getClientOriginalExtension();
                    $file->move('image/avatar', $filename);
                    $user->avatar = $filename;
                }
                $this->save($user, $inputs);
            }
        }
	}

	/**
	 * Get statut of authenticated user.
	 *
	 * @return string
	 */
	public function getStatut()
	{
		return session('statut');
	}

	/**
	 * Create and return directory name for redactor.
	 *
	 * @return string
	 */
	public function getName()
	{
		$name = strtolower(strtr(utf8_decode(Auth::user()->username), 
			utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 
			'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
		));

		$directory = base_path() . config('medias.url-files') . $name;

		if (!File::isDirectory($directory))
		{
			File::makeDirectory($directory); 
		}  

		return $name;  
	}

	/**
	 * Valid user.
	 *
     * @param  bool  $valid
     * @param  int   $id
	 * @return void
	 */
	public function valide($valid, $id)
	{
		$user = $this->getById($id);

		$user->valid = $valid == 'true';

		$user->save();
	}

	/**
	 * Destroy a user.
	 *
	 * @param  int $id
	 * @return void
	 */
	public function destroy($id)
	{
		$user = $this->getById($id);

		$user->delete();
	}
    /**
     * admin change password user
     *
     * @param  array  $inputs
     * @param  int    $id
     * @return void
     */
    public function adminchangepassword($inputs, $id)
    {
        $user = $this->getById($id);
        $user->password = bcrypt($inputs['password']);
        $user->save();
    }
    public function findByUserNameOrCreate($userData ,$provider) {
        $user = User::where('provider_id', '=', $userData->id);
        if($userData->email!=null)
        {
            $user = $user->orWhere('email','like',$userData->email);
        }
        $user = $user->first();
        //dd($userData);
        if(!$user) {
            $user = new $this->model;
            $user->fullname = $userData->name;
            $user->fullnameen = khongdau($userData->name);
            $user->username = $userData->nickname==''?$userData->id:$userData->nickname;
            if($userData->email!=null)  $user->email = $userData->email;
            if($provider=='twitter') {
                $user->gender = 3;
            } else {
                $user->gender = $userData->user['gender'] == 'male' ? 1 : 2;
            }
            $user->role_id = 3;
            $user->provider_id =$userData->id;
            $user->provider = $provider;
            $user->status = 1;
            $user->save();

        }

        $this->checkIfUserNeedsUpdating($userData, $user);
        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user) {

        $socialData = [
            //'avatar' => $userData->avatar,
            'email' => $userData->email,
            'name' => $userData->name,
            'username' => $userData->nickname==''?$userData->id:$userData->nickname,
        ];
        $dbData = [
            //'avatar' => $user->avatar,
            'email' => $user->email,
            'name' => $user->fullname,
            'username' => $user->username,
        ];

        if (!empty(array_diff($socialData, $dbData))) {
            //$user->avatar = $userData->avatar;
            //$user->email = $userData->email;
            $user->fullname = $userData->name;
            $user->fullnameen = khongdau($userData->name);
            $user->username = $userData->nickname;
            $user->save();
        }
    }

}