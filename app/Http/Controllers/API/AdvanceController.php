<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;

class AdvanceController extends Controller
{
    use AuthenticatesUsers;

    public function getAdvanced(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $param['defaultValue'] = 1;
            $query = 'select a.id as advance_id, a.tour_id, a.startdate_id, a.room_list,IfNull(a.tour_guide,"") ,a.total_amount,a.advance_received,a.pay_code,IfNull(b.title,"") as tour_name from advance_master a inner join tours b on a.tour_id = b.id where 1=:defaultValue and a.pay_code is not null';

            if (request('DateFrom') != null && request('DateFrom') != '') {
                $query .= ' and a.created_at >= :DateFrom';
                $param['DateFrom'] = request('DateFrom');
            }
            if (request('DateTo') != null && request('DateTo') != '') {
                $query .= ' and a.created_at < :DateTo';
                $param['DateTo'] = request('DateTo');
            }
            $result['data'] = DB::select($query.' order by a.created_at desc limit :limit offset :skip',$param);

            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }

    }

    public function getAdvancedDetails(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'select DATE_FORMAT(a.tour_time, \'%d-%m-%Y\') as thoigian, case when a.period = 0 then N\'Sáng\' when a.period = 1 then N\'Trưa\' else N\'Tối\' end as thoidiem,IfNull(c.fullname,"") as customer_name, a.id,a.master_id, a.customer_id,a.quantity,a.price,a.amount,IfNull(a.note,""),a.istour from advance_details a inner join users c on c.id = a.customer_id where a.master_id = :advanceid';

            $result['data'] = DB::select($query, ['advanceid'=>request('advanceid') ]);
            return response()->json($result, 200);
        } catch (Exception $ex) {
            $result['data'] = [['message' => $ex->getMessage()]];
            return response()->json($result, 401);
        }

    }

    public function insertAdvanceMaster(Request $request)
    {
        $result['status'] = 'error';
        $result['data'] = [];
        try {
            $query = 'INSERT INTO payment_master ( pay_code, pay_date, pay_user, total_amount, pay_method, date_payment, reason, note, created_by, created_at ) VALUES (:pay_code, :pay_date, :pay_user, :total_amount, :pay_method, :date_payment, :reason, :note, :created_by, :created_at )';


            $rs = DB::insert($query, [
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


}