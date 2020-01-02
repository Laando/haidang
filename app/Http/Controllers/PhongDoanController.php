<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Adding;
use App\Models\AddingCate;
use App\Models\Car;
use App\Models\Config;
use App\Models\Gift;
use App\Models\HotelBook;
use App\Models\MemberType;
use App\Models\Order;
use App\Models\Seat;
use App\Models\StartDate;
use App\Models\Tour;
use App\Models\Transport;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Guard;
use App\Models\DestinationPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\View;
use stdClass;

class PhongDoanController extends Controller{
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->middleware('staff');
        $this->middleware('admin',['only'=>['doFinished']]);
        $staffs = User::where('role_id','like','2')->get();
        $eventtimeconfig = Config::where('type','like','golden-hour')->first();
        $this->eventtimeconfig = $eventtimeconfig;
        View::share(compact('staffs','eventtimeconfig'));
    }
    /* HOMEPAGE */
    public function index(Request $request){
        $user = Auth::user();
        $role = $user->role->slug;


        $staff = $request['staff'];

        // Pagination
        $n = 15;

        $tours = DB::table('selftour')
            ->join('typevehicle', 'typevehicle.idtypeVehicle', '=', 'selftour.idType')
            ->join('status_self_tour', 'status_self_tour.idStatus', '=', 'selftour.idStatus')
            ->select('selftour.*', 'typevehicle.vehicle', 'status_self_tour.*')
            ->paginate($n);


        $links = str_replace('/?', '?', $tours->render());

        $staffs = User::where('role_id', 'like', '2')->get();


        return view('front.phongdoan.index',compact(
            'user',
            'role',
            'staffs',
            'links',
            'tours'
        ));
    }
    /* EDIT */
    public function editSelfTour($id, $isUpdated)
    {
        $user = Auth::user();

        $tour = DB::table('selftour')->where('idself_tour', '=', $id)
            ->join('typevehicle', 'typevehicle.idtypeVehicle', '=', 'selftour.idType')
            ->join('status_self_tour', 'status_self_tour.idStatus', '=', 'selftour.idStatus')
            ->select('selftour.*', 'typevehicle.*', 'status_self_tour.*')
            ->get();

        $vehicle= DB::table('typevehicle')
            ->where('idtypeVehicle','!=' ,$tour[0]->idtypeVehicle)
            ->get();

        if ($isUpdated!=1){
            $tourStatus = DB::update('update `selftour` set `idStatus` = 2 where idself_tour = '.$id);
        }
        return view('front.phongdoan.edit', compact('user', 'vehicle' ,'tour', 'tourStatus'));
    }
    /* UPDATE */
    public function updateSelf(Request $request, $id)
    {
        /*$tours = DB::update('update `selftour` set 
            `totalPrice` = '  .$request->input('totalPrice').', 
            `destination` = '.$request->input('des').',
            `idemployee` = '.$request->input('idemployee').', `selftour`.`idStatus` = 3 where idself_tour = '.$id);*/
        $totalCount = $request->input('nguoiLon') + $request->input('treEm');
        $tour = DB::update('update `selftour` set 
            `totalPrice` = ?, 
            `destination` = ?,
            `idemployee` = ?,
            `nguoiLon` = ?,
            `treEm` = ?,
            `totalCount` = ?,
            `countXe` = ?,
            `idType` = ?,
            `phone` = ?,
            `mail` = ?,
            `address` = ?, `selftour`.`idStatus` = ? where idself_tour = '.$id, [$request->input('totalPrice'), $request->input('des'), $request->input('idemployee'), $request->input('nguoiLon'), $request->input('treEm'), $totalCount, $request->input('countXe'), $request->input('phuongTien'),$request->input('phone'), $request->input('email'), $request->input('address'), 3]);
        $isUpdated = 1;
        return redirect('phong-doan/edit/idself_tour='.$id.'/isUpdated='.$isUpdated)->with('thongbao', 'Bạn đã sửa thành công!');

    }
    /* DELETE */
    public function delete($id){
        $selftour = DB::delete('delete from selftour where idself_tour = '.$id);
        return redirect('phong-doan')->with('thongbao', 'Bạn đã xóa thành công!');
    }
    /* DRAW BARCHART */
    public function drawChart(){
        $month =array();
        $year = (new DateTime)->format("Y");
        $result =array();
        for($i=1;$i<=12;$i++){
            $tours = DB::select('SELECT * FROM selftour 
            WHERE year(start_date) = '.$year.' AND idStatus = 1 AND MONTH(start_date) = '.$i, [1]);
            $count = count($tours);
            foreach ($tours as $tour){
                array_push($result,$tour->start_date);
            }

            array_push($month,$count);
        }
        return view('front.phongdoan.thong-ke',
            compact('month', 'result'));
    }

}