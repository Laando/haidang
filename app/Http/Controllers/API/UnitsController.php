<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;

class UnitsController extends Controller
{
    use AuthenticatesUsers;

    public function loadUnit(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'SELECT id,name FROM units ORDER BY name';
            $result['data'] = DB::select($query);
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function insertUnit(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'INSERT INTO units (name) VALUES (:name)';

            $rs = DB::insert($query, [
                'name' => request('name') !== '' && request('name') !== null ? request('name') : null,
            ]);

            if ($rs === 1 || $rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message'=> 'Cập nhật thành công']];
                return response()->json($result, 200);
            }

            $result['data'] = [['message'=> 'Cập nhật không thành công']];
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function checkExistedUnitName(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select count(*) as total from units where name= :name and id <> :id';
            $count = DB::select($query, [
                'name' => request('name') !== null && request('name') !== '' ? request('name') : null,
                'id' => request('id') !== null && request('id') !== '' ? request('id') : null,
            ])[0]->total;
            if ($count <= 0) $result['data'] = [['isExisted' => false]];
            else $result['data'] = [['isExisted' => true]];
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 401);
        }

    }
    public function loadUnitID(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select id from units order by id desc limit 1';
            $unitid = DB::select($query);

            if (count($unitid) > 0) $result['data'] = [['unitid' => $unitid[0]->id]];
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 401);
        }

    }


}