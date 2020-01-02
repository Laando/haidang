<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;

class PaymentController extends Controller
{
    use AuthenticatesUsers;

    public function getPayment(Request $request)
    {
        try {

            //select a.id,a.pay_code,DATE_FORMAT(a.pay_date, '%d-%m-%Y') as pay_date, b.fullname as pay_user,a.total_amount,a.pay_method,a.date_payment,a.reason,a.note,c.fullname as created_by,a.created_at,d.fullname as edited_by,a.edited_at
            //from payment_master a left join users b on a.pay_user = b.id
            //left join users c on a.created_by = c.id
            //left join users d on a.edited_by = d.id
            //where a.created_at >= 'DateFrom(yyyy-mm-dd)' and a.created_at < 'DateTo(yyyy-mm-dd)' order by pay_code desc
            $page = 1;
            $skip = 0;
            $limit = 20;
            if(request('limit') != '' && request('limit') != null) { $limit = (int)request('limit');}
            $result['limit'] = $limit;

            if(request('page') != '' && request('page') != null) {
                $page = (int)request('page');
                $skip = ( $page - 1 ) * $limit;
            }
            $result['currentPage'] = $page;

            $param['defaultNumber'] = 1;

            $querySelect = 'select a.id,a.pay_code,DATE_FORMAT(a.pay_date, \'%d-%m-%Y\') as pay_date, b.fullname as pay_user,a.total_amount,a.pay_method,a.date_payment,a.reason,a.note,c.fullname as created_by,a.created_at,d.fullname as edited_by,a.edited_at';
            $queryCount = 'select count(*) as total';
            $query = ' from payment_master a left join users b on a.pay_user = b.id left join users c on a.created_by = c.id left join users d on a.edited_by = d.id where 1= :defaultNumber';

            if(request('DateFrom') != '' && request('DateFrom') != null) {
                $query = $query.' and a.created_at >= :DateFrom';
                $param['DateFrom'] = request('DateFrom');
            }
            if(request('DateTo') != '' && request('DateTo') != null) {
                $query = $query.' and a.created_at < :DateTo';
                $param['DateTo'] = request('DateTo');
            }
            $total = (int) DB::select($queryCount.$query,$param )[0]->total;
            $param['limit'] = $limit;
            $param['skip'] = $skip;
            $result['total'] = ceil( $total / $limit );
            $result['data'] = DB::select($querySelect.$query.' order by pay_code desc limit :limit offset :skip',$param);

            return response()->json($result,200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function getPaymentDetails(Request $request)
    {
        try {

            //select DATE_FORMAT(a.tour_time, '%d-%m-%Y') as thoigian,  case when a.period = 0 then 'Sáng' when a.period = 1 then 'Trưa' else 'Tối' end as thoidiem,a.customer_id,c.fullname as customer_name, a.quantity,a.price,a.amount,a.note
            //from payment_details a inner join users c on c.id = a.customer_id
            //where a.pay_code = 'pay_code'
            //order by tour_time, period
            $page = 1;
            $skip = 0;
            $limit = 20;
            if(request('limit') != '' && request('limit') != null) { $limit = (int)request('limit');}
            $result['limit'] = $limit;

            if(request('page') != '' && request('page') != null) {
                $page = (int)request('page');
                $skip = ( $page - 1 ) * $limit;
            }
            $result['currentPage'] = $page;

            $param['defaultNumber'] = 1;

            $querySelect = 'select DATE_FORMAT(a.tour_time, \'%d-%m-%Y\') as thoigian,  case when a.period = 0 then \'Sáng\' when a.period = 1 then \'Trưa\' else \'Tối\' end as thoidiem,a.customer_id,c.fullname as customer_name, a.quantity,a.price,a.amount,a.note';
            $queryCount = 'select count(*) as total';
            $query = ' from payment_details a inner join users c on c.id = a.customer_id where 1= :defaultNumber';

            if(request('pay_code') != '' && request('pay_code') != null) {
                $query = $query.' and pay_code = :pay_code';
                $param['pay_code'] = request('pay_code');
            }
            $total = (int) DB::select($queryCount.$query,$param )[0]->total;
            $param['limit'] = $limit;
            $param['skip'] = $skip;
            $result['total'] = ceil( $total / $limit );
            $result['data'] = DB::select($querySelect.$query.' order by tour_time, period limit :limit offset :skip',$param);

            return response()->json($result,200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function getLastPayCode(Request $request)
    {
        try {
            $query = 'select pay_code from payment_master order by created_at desc limit 1';

            $payCodes = DB::select($query);
            $result['pay_code'] = '';
            if( count($payCodes) > 0) {
                $result['pay_code']=$payCodes[0]->pay_code;
            }
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function insertPaymentMaster(Request $request)
    {
        try {
            $query = 'insert into payment_master (pay_code,pay_date,pay_user,total_amount,pay_method,date_payment,reason,note,created_by,created_at) values (:pay_code,:pay_date,:pay_user,:total_amount,:pay_method,:date_payment,:reason,:note,:created_by,:created_at)';

            $result = DB::insert($query, [
                'pay_code'=>request('pay_code'),
                'pay_date'=>request('pay_date'),
                'pay_user'=>request('pay_user'),
                'total_amount'=>request('total_amount'),
                'pay_method'=>request('pay_method'),
                'date_payment'=>request('date_payment'),
                'reason'=>request('reason'),
                'note'=>request('note'),
                'created_by'=>request('created_by'),
                'created_at'=>request('created_at')
            ]);
            if($result === 1) {
                return response()->json( ['status'=>'success'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['status'=>'error'], 401);
    }

    public function insertPaymentDetails(Request $request)
    {
        try {
            $query = 'INSERT INTO payment_details (pay_code,tourtime,period,customer_id,quantity,price,amount,note) VALUES(:pay_code ,:tourtime ,:period ,:customer_id ,:quantity ,:price ,:amount ,:note)';

            $result = DB::insert($query, [
                'pay_code'=>request('pay_code'),
                'tour_time'=>request('tour_time'),
                'period'=>request('period'),
                'customer_id'=>request('customer_id'),
                'quantity'=>request('quantity'),
                'price'=>request('price'),
                'amount'=>request('amount'),
                'note'=>request('note')
            ]);
            if($result === 1) {
                return response()->json( ['status'=>'success'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
        return response()->json(['status'=>'error'], 401);
    }
}