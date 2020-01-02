<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;

class ItemsController extends Controller
{
    use AuthenticatesUsers;

    public function loadItem(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'SELECT a.id,a.name, b.name as unit, a.price, a.disabled , a.unit as unit_id FROM items a inner join units b on a.unit = b.id WHERE (a.id = :id OR 0 = :id1) ORDER BY a.name';
            $result['data'] = DB::select($query,[
            'id' => request('id'),
            'id1' => request('id'),
            ]);
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }

    }
    public function loadUnitID()
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select top 1 id from units order by id desc';
            $result['data'] = DB::select($query);
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }

    }
    public function enableItem(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'update items set disabled = 0 where id = :id';
            $rs = DB::update($query,[
                'id' => request('id'),
            ]);
            if ($rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message'=>'Cập nhật thành công']];
                return response()->json($result, 200);
            }
            $result['data'] = [['message'=>'Cập nhật không thành công']];
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }

    }

    public function insertItem(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'INSERT INTO items (name,name_search,unit,price_in,disabled,created_by,created_at) VALUES (:name,:name_search,:unit,:price_in,:disabled,:created_by,now())';

            $rs = DB::insert($query, [
                'name' => request('name') !== '' && request('name') !== null ? request('name') : null,
                'name_search' => request('name_search') !== '' && request('name_search') !== null ? request('name_search') : null,
                'unit' => request('unit') !== '' && request('unit') !== null ? request('unit') : null,
                'price_in' => request('price_in') !== '' && request('price_in') !== null ? request('price_in') : null,
                'disabled' => request('disabled') !== '' && request('disabled') !== null ? request('disabled') : null,
                'created_by' => request('created_by') !== '' && request('created_by') !== null ? request('created_by') : null,
            ]);
            if ($rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message'=>'Cập nhật thành công']];
                return response()->json($result, 200);
            }
            $result['data'] = [['message'=>'Cập nhật không thành công']];
            return response()->json($result, 200);

        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }

    }

    public function updateItem(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'UPDATE items SET name= :name,name_search= :name_search,unit= :unit,price_in= :price_in,disabled= :disabled,edited_by= :edited_by,edited_at=now() WHERE id = :id';

            $rs = (int)DB::update($query, [
                'id' => request('id'),
                'name' => request('name') !== '' && request('name') !== null ? request('name') : null,
                'name_search' => request('name_search') !== '' && request('name_search') !== null ? request('name_search') : null,
                'unit' => request('unit') != '' && request('unit') !== null ? request('unit') : null,
                'price_in' => request('price_in') !== '' && request('price_in') !== null ? request('price_in') : null,
                'disabled' => request('disabled') !== '' && request('disabled') !== null ? request('disabled') : null,
                'edited_by' => request('edited_by') !== '' && request('edited_by') !== null ? request('edited_by') : null,
            ]);

            if ($rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message'=>'Cập nhật thành công']];
                return response()->json($result, 200);
            }
            $result['data'] = [['message'=>'Cập nhật không thành công']];
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function deleteItem(Request $request)
    {

        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'update items set disabled = 1 where id = :id';
//            $query = 'DELETE FROM items WHERE id = :id';

            $rs = DB::delete($query,[
                'id' => request('id'),
            ]);
            if ($rs === true) {
                $result['status'] = 'success';
                $result['data'] = [['message'=>'Xóa thành công']];
                return response()->json($result, 200);
            }
            $result['data'] = [['message'=>'Xóa không thành công']];
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }

    }

    public function checkExistedItemName(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select count(*) as total from items where name= :name and id <> :id';
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
            return response()->json($result, 200);
        }
        
    }


}