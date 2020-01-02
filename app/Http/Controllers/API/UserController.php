<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;

class UserController extends Controller
{
    use AuthenticatesUsers;

    public function __construct(
        UserRepository $user_gestion,
        RoleRepository $role_gestion)
    {
        $this->user_gestion = $user_gestion;
        $this->role_gestion = $role_gestion;
//        //$this->middleware('admin');
//        $this->middleware('staff');
//        $this->middleware('ajax', ['only' => 'updateSeen']);
    }

    public function customerLogin(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            if (Auth::attempt(['username' => request('Username'), 'password' => request('Password')]) ||
                Auth::attempt(['email' => request('Username'), 'password' => request('Password')]) ||
                Auth::attempt(['phone' => request('Username'), 'password' => request('Password')])
            ) {
                $user = Auth::user();

                if ($user->status == 1) {
                    $success['token'] = $user->createToken('MyApp')->accessToken;
                    $success['id'] = $user->id;
                    $success['username'] = $user->username;
                    $success['email'] = $user->email;
                    $success['phone'] = $user->phone;
                    $success['fullname'] = $user->fullname;
                    $success['fullnameen'] = $user->fullnameen;
                    $success['roleid'] = $user->role_id;

                    $result['status'] = 'success';
                    $result['data'] = [$success];

                    $query = 'Update users set fcm_token = :fcm_token where id=' . $user->id;
                    DB::update($query, [
                        'fcm_token' => request('fcmToken') !== '' && request('fcmToken') !== null ? request('fcmToken') : '',
                    ]);


                    return response()->json($result, 200);
                }
                $result['data'] = [['message' => 'Tài khoản chưa được kích hoạt hoặc không có quyền truy cập']];
                return response()->json($result, 401);
            } else {
                $result['data'] = [['message' => 'Sai tài khoản hoặc mật khẩu']];
                return response()->json($result, 401);
            }
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    public function userLogin(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            if (Auth::attempt(['username' => request('UserName'), 'password' => request('Password')])) {
                $user = Auth::user();

                if (($user->role_id == '5' || $user->role_id == '6' || $user->role_id == '7' ) && $user->status == 1) {
                    $success['token'] = $user->createToken('MyApp')->accessToken;
                    $success['id'] = $user->id;
                    $success['username'] = $user->username;
                    $success['email'] = $user->email;
                    $success['role_id'] = $user->role_id;
                    $success['fullname'] = $user->fullname;
                    $success['fullnameen'] = $user->fullnameen;

                    $result['status'] = 'success';
                    $result['data'] = [$success];
                    return response()->json($result, 200);
                }
                $result['data'] = [['message' => 'Tài khoản chưa được kích hoạt hoặc không có quyền truy cập']];
                return response()->json($result, 401);
            } else {
                $result['data'] = [['message' => 'Sai tài khoản hoặc mật khẩu']];
                return response()->json($result, 401);
            }
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function updateLastLogin(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'Update users set lastlogin = now() where id = :UserID';
            $rs = DB::update($query, [
                'UserID' => request('UserID') !== '' && request('UserID') !== null ? request('UserID') : null,
            ]);

            if ($rs === 1 || $rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message' => 'Cập nhật thành công']];
                return response()->json($result, 200);
            }

            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 401);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    public function loadEmployee(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {

            if (request('month') && request('year') && request('type') && request('form')) {
                $query = 'select id, fullname as `Tên`, phone as `Điện Thoại`, CONCAT(fullnameen," ",phone) as name_search,timecard_id from users where role_id = 2 and status = 1';
                if (request('type') !== 'Edit') {
                    if (request('form') === 'luongcanban') $query .= " and id not in (select nhanvien_id from attendance_monthly where thang = :month and nam = :year) ";
                }
                $query .= ' order by fullname';
                $result['data'] = DB::select($query, [
                    'month' => request('month'),
                    'year' => request('year')
                ]);
                $result['status'] = 'success';
                return response()->json($result, 200);
            }

            if (request('year') && request('type')) {
                $query = 'select id, fullname as `Tên`, phone as `Điện Thoại`, CONCAT(fullnameen," ",phone) as name_search from users where role_id = 2 and status = 1';
                if (request('type') !== 'Edit') {
                    $query .= " and id not in (select staff_id from config_salary where year = :year)";
                }
                $query .= ' order by fullname';
                $result['data'] = DB::select($query, [
                    'year' => request('year')
                ]);
                $result['status'] = 'success';
                return response()->json($result, 200);
            }

            $query = 'select id, fullname as employee_name, timecard_id, fullnameen, fullname as `Tên`, phone as `Điện Thoại` from users where role_id = 2 and status = 1 order by fullname';
            $result['data'] = DB::select($query);
            $result['status'] = 'success';
            return response()->json($result, 200);

        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    public function  updateTimeCardD(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'update users set timecard_id = :timecard_id where id = :id ';
            $rs = DB::update($query, [
                'id' => request('id') !== '' && request('id') !== null ? request('id') : null,
                'timecard_id' => request('timecard_id') !== '' && request('timecard_id') !== null ? request('timecard_id') : null,
            ]);

            if ($rs === 1 || $rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message' => 'Cập nhật thành công']];
                return response()->json($result, 200);
            }

            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 401);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    public function CountEmployee(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = ' select count(*) as total from users where role_id = 2 and status = 1';
            $count = DB::select($query)[0]->total;
            $result['status'] = 'success';
            $result['data'] = [['total' => $count]];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    public function customerRegister(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select count(*) as total from users where email = :email';
            $param = [
                'email' => request('email') !== null && request('email') !== '' ? request('email') : null
            ];
            $count = DB::select($query, $param)[0]->total;
            if ($count > 0) {
                $result['data'] = [['message' => 'Email đã được sử dụng.']];
                return response()->json($result, 200);
            }

            $query = 'select count(*) as total from users where phone = :phone';
            $param = [
                'phone' => request('phone') !== null && request('phone') !== '' ? request('phone') : null
            ];
            $count = DB::select($query, $param)[0]->total;
            if ($count > 0) {
                $result['data'] = [['message' => 'Số điện thoại đã được sử dụng.']];
                return response()->json($result, 200);
            }


            $query = 'INSERT INTO users ( fullname,email,password,role_id,phone,address,status ) VALUES (:fullname,:email,:password,3,:phone,:address,1 )';

            $rs = DB::insert($query, [
                'fullname' => request('fullname'),
                'email' => request('email'),
                'password' => bcrypt(request('password')),
                'phone' => request('phone'),
                'address' => request('address')
            ]);

            if ($rs === 1 || $rs === true) {
                $result['data'] = [['message' => 'Đăng ký tài khoản thành công']];
                $result['status'] = 'success';
                return response()->json($result, 200);
            }

            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }

    }

    public function changePassword(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $user = Auth::guard('api')->user();

            if (
                Auth::guard('web')->attempt(['username' => request('UserName'), 'password' => request('Password')]) ||
                Auth::guard('web')->attempt(['email' => request('UserName'), 'password' => request('Password')]) ||
                Auth::guard('web')->attempt(['phone' => request('UserName'), 'password' => request('Password')])
            ) {
                $user->password = bcrypt(request('NewPassword'));
                $user->token()->revoke();
                $token = $user->createToken('MyApp')->accessToken;
                $user->save();
                $result['data'] = [['message' => 'Đổi mật khẩu thành công.', 'token' => $token]];
                $result['status'] = 'success';
                return response()->json($result, 200);

            } else {
                $result['data'] = [['message' => 'Mật khẩu cũ không đúng']];
                return response()->json($result, 401);
            }

            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['phone' => $request->get('email'), 'password' => $request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }

    public function loadRole(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select id, title from roles where id in (5,6)';
            $result['data'] = DB::select($query);
            $result['status'] = 'success';
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function loadAccountant(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select id, IfNull(fullname,"") as fullname from users where role_id in (5,6) and status = 1';
            $result['data'] = DB::select($query . ' order by fullname');
            $result['status'] = 'success';
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function loadCustomer(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select id, IfNull(fullname,"") as fullname from users where role_id in (3,4) and status = 1 order by fullname';
            $result['data'] = DB::select($query);
            $result['status'] = 'success';
            return response()->json($result, 200);

        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function loadCustomerToGrid(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $param = [];
            $param['defaultNumber'] = 1;
            $query = 'select id,IfNull(username,"") as username,IfNull(email,"") as email,password,role_id,IfNull(fullname,"") as fullname,IfNull(fullnameen,"") as fullnameen,IfNull(phone,"") as phone,dob,IfNull(address,"") as address,case when gender = 1 then \'Nam\' when gender = 2 then \'Nữ\' else \'\' end as gender,status,created_at,updated_at from users where role_id in (3,4) and 1 = :defaultNumber';
            if (request('id') !== null && request('id') !== '' && request('id') !== 0) {
                $query .= ' and id = :id';
                $param['id'] = request('id');
            }

            $result['data'] = DB::select($query . ' order by fullname', $param);
            $result['status'] = 'success';
            $result['id'] = request('id');
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function insertCustomer(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'insert into users (username,email,password,role_id,fullname,fullnameen,phone,dob,address,gender,status,created_at) values (:username,:email,:password,:role_id,:fullname,:fullnameen,:phone,:dob,:address,:gender,:status,now())';


            $rs = (int)DB::insert($query, [
                'username' => request('username') !== '' && request('username') !== null ? request('username') : null,
                'email' => request('email') !== '' && request('email') !== null ? request('email') : null,
                'password' => request('password') !== '' && request('password') !== null ? bcrypt(request('password')) : null,
                'role_id' => request('role_id') !== '' && request('role_id') !== null ? request('role_id') : null,
                'fullname' => request('fullname') !== '' && request('fullname') !== null ? request('fullname') : null,
                'fullnameen' => request('fullnameen') !== '' && request('fullnameen') !== null ? request('fullnameen') : null,
                'phone' => request('phone') !== '' && request('phone') !== null ? request('phone') : null,
                'dob' => request('dob') !== '' && request('dob') !== null ? request('dob') : null,
                'address' => request('address') !== '' && request('address') !== null ? request('address') : null,
                'gender' => request('gender') !== '' && request('gender') !== null ? request('gender') : null,
                'status' => request('status') !== '' && request('status') !== null ? request('status') : null
            ]);

            if ($rs === 1 || $rs === true) {
                $result['data'] = [['message' => 'Cập nhật thành công']];
                $result['status'] = 'success';
                return response()->json($result, 200);
            }

            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    public function updateCustomer(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'update users set username = :username,email = :email,role_id = :role_id,fullname = :fullname,fullnameen = :fullnameen,phone = :phone,dob = :dob,address = :address,gender = :gender,updated_at = now() where id = :id';

            $rs = (int)DB::update($query, [
                'id' => request('id'),
                'username' => request('username') !== '' && request('username') !== null ? request('username') : null,
                'email' => request('email') !== '' && request('email') !== null ? request('email') : null,
                'role_id' => request('role_id') !== '' && request('role_id') !== null ? request('role_id') : null,
                'fullname' => request('fullname') !== '' && request('fullname') !== null ? request('fullname') : null,
                'fullnameen' => request('fullnameen') !== '' && request('fullnameen') !== null ? request('fullnameen') : null,
                'phone' => request('phone') !== '' && request('phone') !== null ? request('phone') : null,
                'dob' => request('dob') !== '' && request('dob') !== null ? request('dob') : null,
                'address' => request('address') !== '' && request('address') !== null ? request('address') : null,
                'gender' => request('gender') !== '' && request('gender') !== null ? request('gender') : null
            ]);

            if ($rs === 1 || $rs === true) {
                $result['data'] = [['message' => 'Cập nhật thành công']];
                $result['status'] = 'success';
                return response()->json($result, 200);
            }
            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function enableCustomer(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $queryUpdate = 'update users set status = 1 where id = :id';
            $rs = (int)DB::update($queryUpdate, ['id' => request('id')]);

            if ($rs === 1 || $rs === true) {
                $result['data'] = [['message' => 'Cập nhật thành công']];
                $result['status'] = 'success';
                return response()->json($result, 200);
            }

            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function deleteCustomer(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'update users set status = 0 where id = :id';
            $rs = (int)DB::update($query, [
                'id' => request('id') !== null && request('id') !== '' ? request('id') : null,
            ]);

            if ($rs === 1 || $rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message' => 'Xóa thành công']];
                return response()->json($result, 200);
            }

            $result['data'] = [['message' => 'Xóa không thành công']];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function checkExistedEmail(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select count(*) as total from users where email = :email and id <> :id';

            $param = [
                'email' => request('email') !== null && request('email') !== '' ? request('email') : null,
                'id' => request('id') !== null && request('id') !== '' ? request('id') : null,
            ];
            $count = DB::select($query, $param)[0]->total;

            if ($count <= 0) $result['data'] = [['isExisted' => false]];
            else $result['data'] = [['isExisted' => true]];
            $result['status'] = 'success';
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }

    public function checkExistedPhone(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select count(*) as total from users where phone= :phone and id <> :id';
            $count = DB::select($query, [
                'phone' => request('phone') !== null && request('phone') !== '' ? request('phone') : null,
                'id' => request('id') !== null && request('id') !== '' ? request('id') : null,
            ])[0]->total;
            if ($count <= 0) $result['data'] = [['isExisted' => false]];
            else $result['data'] = [['isExisted' => true]];
            $result['status'] = 'success';
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
    }


    public function getFirstDate(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $start = new Carbon('first day of this month');
            $result['data'] = [$start];
            $result['status'] = 'success';
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function getCurrentDateTime(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $date_rtn = Carbon::now();
            $result['data'] = [$date_rtn];
            $result['status'] = 'success';
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function executeSQL(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        $query = request('SQL');
        $isMulti = request('multi');
        if (isset($isMulti) && $isMulti == 1) {
            $isMulti = true;
        } else {
            $isMulti = false;
        }
        //var_dump($isMulti);die;
        if ($isMulti) {
            DB::beginTransaction();
            try {
                DB::unprepared(DB::raw($query));
                $result['data'] = ['Thực thi thành công'];
                $result['status'] = 'success';
                DB::commit();
                return response()->json($result, 200);
            } catch (Exception $ex) {
                DB::rollBack();
                $result['data'] = [['message' => $ex->getMessage()]];
                $result['query'] = $query;
                return response()->json($result, 200);
            }
        }
        $queries = explode(' ; ', $query);
        DB::beginTransaction();
        foreach ($queries as $index => $query) {
            try {
                $query = trim($query);
                $command = strtolower(substr($query, 0, 6));

                switch ($command) {
                    case 'select' :
                        $result['status'] = 'success';
                        $result['data'] = DB::select($query);
                        break;
                    case 'insert' :
                        $rs = DB::insert($query);
                        if ($rs === 1 || $rs === true) {
                            $result['data'] = 'Tạo mới thành công';
                            $result['status'] = 'success';
                        } else {
                            $result['data'] = 'Tạo mới không thành công';
                        }
                        break;
                    case 'update' :
                        $rs = DB::update($query);
                        if ($rs === 1 || $rs === true) {
                            $result['data'] = 'Cập nhật thành công';
                            $result['status'] = 'success';
                        } else {
                            $result['data'] = 'Cập nhật không thành công';
                            $result['status'] = 'success';
                        }
                        break;
                    case 'delete' :
                        $rs = DB::delete($query);
                        if ($rs === 1 || $rs === true) {
                            $result['data'] = 'Xóa thành công';
                            $result['status'] = 'success';
                        } else {
                            $result['data'] = 'Xóa không thành công';
                            $result['status'] = 'success';
                        }
                        break;
                    default :
                        DB::rollBack();
                        $result['data'] = [['message' => 'Câu lệnh không hợp lệ']];
                        $result['query'] = $query;
                        return response()->json($result, 200);
                        break;
                }
            } catch (Exception $ex) {
                DB::rollBack();
                $result['data'] = [['message' => $ex->getMessage()]];
                $result['query'] = $query;
                return response()->json($result, 200);
            }
        }
        DB::commit();
        return response()->json($result, 200);
    }


    public function uploadFile(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            if ($request->hasFile('file')) {
                $result['data'] = [['message' => 'Có file']];
                return $result;
            }
        } catch (Exception $ex) {

        }
    }

    public function test(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {

            $query = 'INSERT INTO users ( fullname,email,password,role_id,phone,address,status ) VALUES (:fullname,:email,:password,3,:phone,:address,1 )';

            $rs = DB::insert($query, [
                'fullname' => 'Việt Anh',
                'email' => 'phamhoangviet.anh136@gmail.com',
                'password' => bcrypt('123'),
                'phone' => '0378323772',
                'address' => 'Quận 7'
            ]);

            if ($rs === 1 || $rs === true) {
                $result['data'] = [['message' => 'Đăng ký tài khoản thành công']];
                $result['status'] = 'success';
                return response()->json($result, 200);
            }

            $result['data'] = [['message' => 'Cập nhật không thành công']];
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }
        return response()->json(bcrypt(request('password')), 200);
    }


}