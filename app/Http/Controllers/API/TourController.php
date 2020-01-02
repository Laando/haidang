<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;

class TourController extends Controller
{
    use AuthenticatesUsers;

    public function loadTour(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $param['defaultNumber'] = 1;
            $query = 'SELECT id, title FROM tours where 1= :defaultNumber and status = 1';

            $result['data'] = DB::select($query . ' ORDER BY title', $param);
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }
    }

    public function loadStartDateByTour(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $param['defaultNumber'] = 1;
            $query= 'SELECT id, DATE_FORMAT(startdate, \'%d-%m-%Y\') AS startdate, traffic FROM start_dates where 1= :defaultNumber';

            if (request('id') !== '' && request('id') !== null) {
                $query = $query . ' and tour_id = :id';
                $param['id'] = (int)request('id');
            }

            if (request('DateTo') !== '' && request('DateTo') !== null) {
                $query = $query . ' and startdate < :DateTo';
                $param['DateTo'] = request('DateTo');
            }

            if (request('DateFrom') !== '' && request('DateFrom') !== null) {
                $query = $query . ' and startdate >= :DateFrom';
                $param['DateFrom'] = request('DateFrom');
            }


            $result['data'] = DB::select( $query . ' ORDER BY startdate', $param);
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            $result['data'] = [['message'=> $ex->getMessage()]];
            return response()->json($result, 200);
        }


    }




}