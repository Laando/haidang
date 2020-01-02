<?php namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\AdminChangePasswordUserRequest;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller {

    /**
     * The UserRepository instance.
     *
     * @var App\Repositories\UserRepository
     */
    protected $user_gestion;

    /**
     * The RoleRepository instance.
     *
     * @var App\Repositories\RoleRepository
     */
    protected $role_gestion;

    /**
     * Create a new UserController instance.
     *
     * @param  App\Repositories\UserRepository $user_gestion
     * @param  App\Repositories\RoleRepository $role_gestion
     * @return void
     */
    public function __construct(
        UserRepository $user_gestion,
        RoleRepository $role_gestion)
    {
        $this->user_gestion = $user_gestion;
        $this->role_gestion = $role_gestion;

        //$this->middleware('admin');
        $this->middleware('staff');
        $this->middleware('ajax', ['only' => 'updateSeen']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->indexGo('total');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $role
     * @return Response
     */
    public function indexSort($role)
    {
        return $this->indexGo($role, true);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $role
     * @param  bool    $ajax
     * @return Response
     */
    private function indexGo($role, $ajax = false )
    {
        $search = null;
        if(Input::get('search')!='') {
            $search = Input::get('search');
        }
        $counts = $this->user_gestion->counts();
        // show users with 10 users per page
        $users = $this->user_gestion->index(10, $role , $search);
        //dd($users->render());
        $links = str_replace('/?', '?', $users->render());
        $roles = $this->role_gestion->all();
        if($ajax)
        {
            return response()->json([
                'view' => view('back.users.table', compact('users', 'links', 'counts', 'roles'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }

        return view('back.users.index', compact('users', 'links', 'counts', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('back.users.create', $this->user_gestion->create());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\requests\UserCreateRequest $request
     *
     * @return Response
     */
    public function store(
        UserCreateRequest $request)
    {
        $this->user_gestion->store($request->all());
        $user  = Auth::user();
        if($user->role->slug=='staff') {
            return redirect('staff/customer')->with('ok', trans('back/users.created'));
        } else {
            return redirect('user')->with('ok', trans('back/users.created'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('back.users.show',  $this->user_gestion->show($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('back.users.edit',  $this->user_gestion->edit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\requests\UserUpdateRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(
        UserUpdateRequest $request,
        $id)
    {
        $this->user_gestion->update($request->all(), $id);
        $user  = Auth::user();
        if($user->role->slug=='staff') {
            return redirect('staff/customer')->with('ok', trans('back/users.updated'));
        } else {
            return redirect('user')->with('ok', trans('back/users.updated'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request $request
     * @param  int  $id
     * @return Response
     */
    public function updateSeen(
        Request $request,
        $id)
    {
        $this->user_gestion->update($request->all(), $id);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->user_gestion->destroy($id);

        return redirect('user')->with('ok', trans('back/users.destroyed'));
    }

    /**
     * Display the roles form
     *
     * @return Response
     */
    public function getRoles()
    {
        $roles = $this->role_gestion->all();

        return view('back.users.roles', compact('roles'));
    }

    /**
     * Update roles
     *
     * @param  App\requests\RoleRequest $request
     * @return Response
     */
    public function postRoles(RoleRequest $request)
    {
        $this->role_gestion->update($request->except('_token'));

        return redirect('user/roles')->with('ok', trans('back/roles.ok'));
    }
    /**
     * Update the password of User from Admin Role
     *
     * @param  App\Requests\Request $request
     * @param  int  $id
     * @return Response
     */
    public function AdminChangePasswordUser(AdminChangePasswordUserRequest $request , $id)
    {
        $this->user_gestion->adminchangepassword($request->all(), $id);

        return redirect('user')->with('ok', 'Đổi password thành công');
    }

}
