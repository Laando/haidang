<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;

class MaxIDController extends Controller
{
    use AuthenticatesUsers;

    public function getMaxID(Request $request)
    {
        try {
            $query = 'select * from max_id';
            $result = DB::select($query);
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function updateMaxPayment(Request $request)
    {
        try {
            $query = 'update max_id set paymentid = paymentid + 1';
            $result = DB::update($query);
            if($result === 1) {
                return response()->json( ['status'=>'success'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['status' => 'error'], 401);
    }

    public function updateMaxReceipt(Request $request)
    {
        try {
            $query = 'update max_id set receiptid = receiptid + 1';
            $result = DB::update($query);
            if($result === 1) {
                return response()->json( ['status'=>'success'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['status' => 'error'], 401);
    }

    public function updateMaxImport(Request $request)
    {
        try {
            $query = 'update max_id set importid = importid + 1';
            $result = DB::update($query);
            if($result === 1) {
                return response()->json( ['status'=>'success'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['status' => 'error'], 401);
    }
    
    public function updateMaxExport(Request $request)
    {
        try {
            $query = 'update max_id set exportid = exportid + 1';
            $result = DB::update($query);
            if($result === 1) {
                return response()->json( ['status'=>'success'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['status' => 'error'], 401);
    }
}