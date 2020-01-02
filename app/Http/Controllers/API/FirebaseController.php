<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mockery\CountValidator\Exception;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;

class FirebaseController extends Controller
{
    use AuthenticatesUsers;
    public function __construct(
        UserRepository $user_gestion,
        RoleRepository $role_gestion)
    {
        $this->user_gestion = $user_gestion;
        $this->role_gestion = $role_gestion;
    }
    public function testFirebase(){
        return response()->json('testFirebase', 200);
    }
    public function sendNotificationRequest($deviceID,$apiKey, $data)
    {
        $fields = array('to' => $deviceID, 'notification' => $data);
        $headers = array('Authorization: key=' . $apiKey, 'Content-Type: application/json');

        $url = 'https://fcm.googleapis.com/fcm/send';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    public function sendNotification(Request $request)
    {       
        $result['status'] = 'error';
        $apikey = 'AIzaSyBVw_d5DgSmgIinUgw4Us8lvEy_YxnkGOM';
        try {
            $rs = DB::select('select fcm_token from users where fcm_token is not null and fcm_token <> \'\' ');
            for($i = 0;$i < count($rs) ;$i++) {
                $this->sendNotificationRequest($rs[$i]->fcm_token,$apikey ,
                    array(
                        'body' => request('body'),
                        'title' => request('title')
                    )
                );
            }
            $result['status'] = 'success';
            return response()->json($result, 200);
        }catch (Exception $ex) {
            return response()->json($result, 401);
        }
    }



}