<?php

namespace App\Http\Controllers;


use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelfTourController extends Controller
{

    public function CreateTour(Request $request){
        // Bước 1: Nhận các giá trị input từ form
        $name = $request->input('txtFullName');
        $phone = $request->input('txtPhone');
        $mail = $request->input('txtMail');
        $address = $request->input('txtAddress');
        $destination = $request->input('txtDestination');
        $starHotel = $request->input('txtStar');
        $startDate = $request->input('txtStartDate');
        $nguoiLon = (int) $request->input('txtAdult');
        $treEm = (int) $request->input('txtChildren');
        $count = $nguoiLon + $treEm;
        $typeVehicle = $request->input('txtTypeVehicle');

        // Bước 2: Thực thi truy vấn SQL bằng PDO
        // Controller gọi Model
        DB::insert('INSERT INTO `selftour` (`name`, `phone`, `mail`, `address`, `destination`, `star`, `start_date`, `nguoiLon`, `treEm`, `totalCount`, `idType`) VALUES (?,?,?,?,?,?,?,?,?,?,?);
',[$name, $phone, $mail, $address, $destination
                    ,$starHotel, $startDate , $nguoiLon, $treEm, $count, $typeVehicle]);

        $vehicle= DB::table('typevehicle')
            ->select('*')
            ->where('idtypeVehicle','=',$typeVehicle)
            ->get();

        $isCommit = 1;

        // Bước 3
        // Model trả kết quả về Controller
        // Controller compact trị và trả về Views
        return view('front.success', compact('name', 'phone', 'mail'
        , 'address', 'destination', 'starHotel', 'startDate', 'nguoiLon', 'treEm', 'count', 'vehicle' , 'isCommit'));
    }

    public function GetAll(){
        $tour = DB::table('selftour')
            ->select('*')
            ->join('typevehicle','typevehicle.idtypeVehicle','=','selftour.idType')
            ->get();

        return view('', compact('tour'));
    }


}