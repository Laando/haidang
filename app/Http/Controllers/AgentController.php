<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Adding;
use App\Models\AddingCate;
use App\Models\Car;
use App\Models\Config;
use App\Models\Gift;
use App\Models\Order;
use App\Models\Seat;
use App\Models\StartDate;
use App\Models\Tour;
use App\Models\Transport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Guard;
use App\Models\DestinationPoint;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
class AgentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('agent');
        $staffs = User::where('role_id','like','2')->get();
        View::share(compact('staffs'));
    }
	public function index(Request $request)
	{
        $user = Auth::user();
        $role = $user->role->slug;

        $destinationpoints =  DestinationPoint::orderBy('priority','ASC')->get();

            $staff = $request['staff'];
            $destinationpoint = $request['destinationpoint'];
            $startdate = $request['start'];
            $tours = Tour::where('status','=','1');

            if($staff != '' && is_numeric($staff))
                $tours = $tours->where('user_id','=',$staff);

            if($destinationpoint !='' && is_numeric($destinationpoint))
                $tours =  $tours->whereHas('destinationpoints', function($q) use ($destinationpoint) {
                    $q->where('id','=', $destinationpoint);//condition for tour has subject has homepage on;
                });

            if($startdate != '' && checkValidDate($startdate))
            {

                $arr = explode('/',$startdate);
                $startdate = $arr[2].'-'.$arr[1].'-'.$arr[0];
                $tours = $tours->whereHas('startdates',function ($q) use ($startdate) {
                   $q->where('startdate','like',$startdate.'%');
                });
            }
            $tours = $tours->get();
            $hasstartdates  = StartDate::where('startdate','>',new \DateTime())pluck('startdate')->all();
            //dd($hasstartdates);
        //$arrtours = $user->tours()pluck('id');
        //$startdates = StartDate::whereIn('tour_id',$arrtours)->where('startdate','>','now()')->orderBy('startdate','DESC')->get();
		return view('front.agent.index',compact(
            'user',
            'role',
            'destinationpoints',
            'tours',
            'request',
            'hasstartdates'
        ));
	}

    public function tour()
    {

        $user = Auth::user();
        $role = $user->role->slug;
        if($role=='admin') {
            $orders = Order::whereStatus(1)->get();
            $countod = count($orders);
            $countgod = 0;
            $countg1 = 0;
            $countg2 = 0;
        } else {
            $orders = Order::where('tourstaff_id','=',$user->id)->where('status','!=','0')->whereStatus(1)->get();
            $countod = count($orders);
            $gorders  = Order::where('tourstaff_id','=',$user->id)->where('staff_id','!=',$user->id)->where('status','!=','0')->whereStatus(1)->get();
            $countgod = count($gorders);
            $g1orders= Order::where('tourstaff_id','!=',$user->id)->where('staff_id','=',$user->id)->where('status','!=','0')->whereStatus(1)->get();
            $countg1 = count($g1orders);
            $g2orders= Order::where('tourstaff_id','!=',$user->id)->where('staff_id','=',$user->id)->where('status','!=','0')->whereStatus(2)->get();
            $countg2 = count($g2orders);
            //die($orders);
        }
        return view('front.agent.tour',compact(
            'user',
            'role',
            'countod',
            'countgod',
            'countg1',
            'countg2'
        ));
    }
    public function order($given = null)
    {
        $n = 50;
        $user = Auth::user();
        $role = $user->role->slug;
        if($role=='admin') {
            $orders = Order::where('status','>=','0');
        } else {
            $orders = Order::where('tourstaff_id','=',$user->id);
            if($given=='0')
            {
                $orders = $orders->where('staff_id','!=',$user->id);
            }
            if($given=='1'){
                $orders = Order::where('tourstaff_id','!=',$user->id)->where('staff_id','=',$user->id)->whereStatus(1);
            }
            if($given=='2'){
                $orders = Order::where('tourstaff_id','!=',$user->id)->where('staff_id','=',$user->id)->whereStatus(2);
            }
        }

        $str = Input::get('str');
        $status = Input::get('status');
        $start = Input::get('start');
        $end = Input::get('end');
        if($str!='') {
            $str = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
            $orders = $orders->whereId($str);
        }
        if($status!=''){
            if($status=='0'){

            }
            else
            {
                $orders = $orders->where('status','>','0');
            }
            if($status!='4') {
                $orders = $orders->where('status', '=', $status);
            } else {
                $orders = $orders->where('deposit', '=', 0)->where('status', '!=', 3);
            }
        } else {
            $orders = $orders->where('status','>','0');
        }
        if(!($start==''&&$end==''))
        {
            if($start!=''){//has end
                $dtstart = Carbon::createFromFormat('d/m/Y',$start);
                $orders = $orders->where('created_at','>=',Carbon::create($dtstart->year,$dtstart->month,$dtstart->day,0,0,0));
            }
            if($end!=''){//has start
                $dtend = Carbon::createFromFormat('d/m/Y',$end);
                $orders = $orders->where('created_at','<=',Carbon::create($dtend->year,$dtend->month,$dtend->day,23,59,59));
            }
            //dd($orders);
            //dd(Carbon::create($dtend->year,$dtend->month,$dtend->day,23,59,59));
        }
        //dd($orders->toSql());
        $total = $orders->count();
        if($role!='admin'&&$given==null&&$status!='3'){
            $orders = $orders->where('status','!=',3);
        }
        $orders = $orders->orderBy('status')->latest()->paginate($n);
        //dd($orders);
        $links = str_replace('/?', '?', $orders->render());
        return view('front.agent.order',compact(
            'user',
            'role',
            'links',
            'orders',
            'total'
        ));
    }
    public function givenOrder($give = null)
    {
        if($give == '') $give = 0;
        return $this->order($give);
    }


    public function editOrder($isnew = null)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        //if(Input::get('create')=='new'&&$user->role->slug!='admin'){
        //    $tours = Tour::whereStatus(1)->where('user_id','=',$user->id)->latest()->get();
        //} else {
            $tours = Tour::whereStatus(1)->where('user_id','=',$user->id)->latest()->get();
        //}
        $tour = null;
        $startdate = null;
        $startdates = null;
        $notice = '';
        $configdeal = Config::where('type','like','deal-brand')->first();
        $deals = explode(';',trim($configdeal->content,';'));
        if(!is_numeric($isnew))
        {
            $useredit = null;
            if($startdate !=null) {
                $noforcedaddings = $startdate->addings()->whereHas('addingcate',function($q) {
                    $q->where('isForced','=','0');
                })->get();
            } else {
                $noforcedaddings = null;
            }
            $allstartdates =  StartDate::where('startdate','>',new \DateTime())->orderBy('startdate','ASC')->get();
            $order = new Order();
            $order->id = '';
            if(Input::get('tourid')!=''&&is_numeric(Input::get('tourid')))
            {
                $tour = Tour::find(Input::get('tourid'));
                $tours = Tour::whereStatus(1)->latest()->get();
            }
            return view('front.agent.orderedit',compact(
                'order',
                'user',
                'role',
                'useredit',
                'tours',
                'tour',
                'noforcedaddings',
                'allstartdates',
                'startdates',
                'notice',
                'deals'
            ));
        }
        else
        {
            $id = $isnew;
            $order = Order::find($id);
            //dd($tours);
            if($user->role->slug!='admin') {
                if ($user->id != $order->touragent_id)
                {
                    //$messages = new MessageBag;
                    //$messages->add('StatusError', 'Bạn không có quyền này ! Vui lòng liên hệ '.$order->touragent->fullname);
                    //return  redirect()->intended('agent/neworder')->withErrors($messages)->with('StatusError','fail');
                }
                if($order->status == 0)
                {
                    $messages = new MessageBag;
                    $messages->add('StatusError', 'Đơn hàng đã hủy không thể chỉnh sửa');
                    return  redirect()->intended('agent/neworder')->withErrors($messages)->with('StatusError','fail');
                }
            }
            $useredit = User::find($order->customer_id);
            $startdate = $order->startdate;
            if($startdate !=null) {
                $noforcedaddings = $startdate->addings()->whereHas('addingcate',function($q) {
                    $q->where('isForced','=','0')->where('id','!=','2')->where('id','!=','3')->where('id','!=','5');
                })->get();
            } else {
                $noforcedaddings = null;
            }
            $timenow = Carbon::now();
            $timecheck = Carbon::createFromFormat('Y-m-d H:i:s',$order->startdate->startdate);
            //dd($timecheck);
            if($timenow->diffInHours($timecheck, false)<0) {
                $allstartdates = StartDate::where('startdate', '>', $order->startdate->startdate)->orWhere('id','=',$order->startdate->id)->orderBy('startdate', 'ASC')->get();
            } else {
                $allstartdates = StartDate::where('startdate', '>=', $order->startdate->startdate)->orderBy('startdate', 'ASC')->get();
            }
            //dd($order->startdate->startdate);
            /////////////here
            $arraddings = array();

            $addings = $order->addings()->whereHas('addingcate', function ($q) {
                    $q->where('isForced', '=', '0')->where('id', '!=', '2')->where('id', '!=', '3')->where('id', '!=', '5');
                })->get();

            foreach($addings as $add){
                if(array_key_exists ( $add->id ,$arraddings )) {
                    $count = $arraddings[$add->id];
                    $arraddings[$add->id] = $count+1;
                } else {
                    $arraddings[$add->id] = 1;
                }
            }
            $transports = $order->startdate->transports()->get();
            $transport = $transports->first();
            $currentseat = 0;
            $sseat = array();
            if($transport !=null) {
                $currentseat = $transport->seats()->where('order_id', 'like', $order->id)->count();
                $sseat = $transport->seats()->where('order_id', 'like', $order->id)pluck('number')->all();
                $notice = '';
            } else {
                $notice = 'Chưa tạo xe';
            }
            $tour = $order->startdate->tour;
            return view('front.agent.orderedit',compact(
                'order',
                'user',
                'role',
                'useredit',
                'tours',
                'tour',
                'noforcedaddings',
                'allstartdates',
                'startdates',
                'arraddings',
                'transports',
                'transport',
                'currentseat',
                'notice',
                'sseat',
                'deals'
            ));
        }
    }
    public function newOrder()
    {
        return $this->editOrder('true');
    }
    public function showCalculate(Request $request){
        $user = Auth::user();
        $role = $user->role->slug;
        if($request->ajax())
        {
            if(is_numeric($request['id']))
            {
                $tour = Tour::find($request['id']);
                $order = new Order();
                $order->id ='';
                return view('front.user.partials.calculatetable',compact('tour','startdates','order'));
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
    public function createUser(CreateUserRequest $request)
    {
        if($request->ajax())
        {
            $messages = new MessageBag;
            $username = $request->username ;
            $email = $request->email;
            $phone = $request->phone;
            $fullname = $request->fullname;
            $password = $request->password;
            $gender = $request->gender;
            $address = $request->address;
            $users = User::where('role_id','=',3)->where('username','like',$username)->orWhere('email','like',$email)->orWhere('phone','like',$phone)->get();
            if(count($users)>0) {
                $user = array();

                foreach($users as $u){
                    $messages->add('UserExist', ['id'=>$u->id,'username'=>$u->username,'email'=>$u->email,'phone'=>$u->phone]);
                }
                return json_encode($messages);
            }
            $user = new User();
            if($username!='')  $user->username = $username;
            if($email!='') $user->email = $email;
            $user->phone = $phone;
            $user->fullname = $fullname;
            $user->password = bcrypt($password);
            $user->gender = $gender;
            $user->address = $address;
            $user->role_id = 3;
            $user->status = 1;
            $user->save();
            $messages->add('CreateUserSuccess',['id'=>$user->id]);
            return json_encode($messages);
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
    public function checkUser(Request $request)
    {
        if($request->ajax())
        {
            $str = $request['str'];
            $type = $request['type'];
            // user register by social tool will be filte out or phone number is null
            $users = User::where('role_id','=',3)->where('phone','!=','');
            switch($type){
                case 'username' :
                    $users = $users->where('username','like',$str)->get();
                    break;
                case 'phone' :
                    $users = $users->where('phone','like',$str)->get();
                    break;
                case 'email':
                    $users = $users->where('email','like',$str)->get();
                    break;
            }
            if(count($users)>0) {
                $user = array();
                $messages = new MessageBag;
                foreach($users as $u){
                    $messages->add('UserExist', ['id'=>$u->id,'username'=>$u->username,'email'=>$u->email,'phone'=>$u->phone]);
                }
                return json_encode($messages);
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
    public function createOrder()
    {
        ////////////////////////////valid createOrder reuqest
        $currentyear = date('Y');
        $minyear = $currentyear - 10;
        $messages = array(
            'required' => ':attribute không được để trống',
            'numeric' => ':attribute phải là số',
            'exists' => ':attribute không tồn tại',
        );
        $inputs = Input::all();
        $validator = Validator::make($inputs, [
            'user' => 'required|numeric|exists:users,id',
            'starhotel' => 'required|numeric',
            'selectedstartdate' => 'required|numeric|exists:start_dates,id',
            'soluong' => 'required|numeric',
            'sotreem' => 'numeric',
            'deposit' => 'numeric',
            'discount' => 'numeric'
        ], $messages);
        $niceNames = array(
            'user' => 'Khách hàng',
            'starhotel' => 'Chọn sao',
            'selectedstartdate' => 'Ngày khởi hành',
            'soluong' => 'Số người lớn',
            'sotreem' => 'Số trẻ em',
            'deposit' => 'Tiền cọc',
            'discount'=> 'Giảm giá'
        );
        if (isset($inputs['year'])) {
            $countyear = count($inputs['year']);
            $validator->mergeRules("sotreem", 'numeric|between:0,100|between:' . $countyear . ',' . $countyear);
        }
        $year = array();
        if (isset($inputs['year'])) {
            $cchosens = $inputs['cchosen'];
            foreach ($inputs['year'] as $key => $value) {
                $validator->mergeRules("year.$key", "numeric|between:$minyear,$currentyear");
                $validator->mergeRules("cchosen.$key", "numeric|between:0,1");
                $niceNames["year.$key"] = 'Năm sinh';
                $year[] = array('year' => $value, 'chosen' => $cchosens[$key]);
            }
        }
        //adding more
        $moreaddings = array();
        if (isset($inputs['addingid'])) {
            $amounts = $inputs['amount'];
            foreach ($inputs['addingid'] as $key => $value) {
                $validator->mergeRules("addingid.$key", "numeric|exists:addings,id");
                $validator->mergeRules("amount.$key", "numeric");
                $niceNames["addingid.$key"] = 'Phụ thu';
                $moreaddings[]=array('adding' => $value, 'amount' => $amounts[$key]);
            }
        }
        //////////////////////////////
        $validator->setAttributeNames($niceNames);
        if ($validator->fails()) {
            Session::flash('createError','e');
            //dd($validator->errors());
            return  redirect()->back()->withInput()->withErrors($validator->errors());
        }
        ///////////////////////check create new or edit
        //if(is_numeric($request['id'])||$request['id']!='')
        //{
        //    $order = Order::find($request['id']);
         //   $oldtotal = $order->total;
        //    $oldstartdate = $order->startdate->id;
        //    $notice = "Cập nhật đơn hàng thành công";
        //    $customer = $order->customer;
        //    $isnew = false;
        //}    else {
            $order = new Order();
            $notice = 'Tạo mới đơn hàng thành công !';
            //$ỏ$customer = User::find($inputs['user']);
            ////////////set order for the agent that working with customer
            $order->staff_id = $this->auth->user()->id;
            $order->status = 1;
        //}
        //Calculate ADDINGS
        $startdate = StartDate::find($inputs['selectedstartdate']);
        $forcedaddings = $startdate->addings()->whereHas('addingcate' , function($q) {
            $q->where('isForced','=',1);
        })->get();
        $totalforcedadding  = 0;
        foreach($forcedaddings as $adding)
        {
            $totalforcedadding += $adding->price;
        }
        $sellprice = ($inputs['starhotel'])+$totalforcedadding;
        //calculate child price
        $childgt5adding = $startdate->addings()->whereHas('addingcate' , function($q) {
            $q->whereId(2);
        })->first();
        $childgtsixprice = 0;
        if($childgt5adding==null) $childgt5adding = new Adding();
        $childgtsixprice = $childgt5adding->price;
        $childgtsixprice = round($childgtsixprice*$sellprice/100,-3);
        $childlt5adding = $startdate->addings()->whereHas('addingcate' , function($q) {
            $q->whereId(3);
        })->first();
        $childltsixprice = 0;
        if($childlt5adding==null)  $childlt5adding = new Adding();
        $childltsixprice = $childlt5adding->price;
        $childlt550adding = $startdate->addings()->whereHas('addingcate' , function($q) {
            $q->whereId(5);
        })->first();
        $childltsix50price = 0;
        if($childlt550adding==null)  $childlt550adding= new Adding();
        $childltsix50price = $childlt550adding->price;
        $childltsix50price = round($childltsix50price*$sellprice/100,-3);
        //free child
        $freechild = floor(($inputs['soluong'])/2);
        //childlist
        $childlist = '';
        $count = 0;//ttmp seats
        $currentyear = date('Y');
        $childgt5addingid = array();// total child >5y
        $childlt550addingid = array();//total child <5 but got 50% price
        $childlt5addingid = array();//total free child buy seat
        foreach($year as $index => $value)
        {
            //make arr childlist
            $childyear = $value['year'];
            $childyear = $childyear * 1 ;
            $childchosen = $value['chosen'];
            $childlist .= $childyear.'-'.$childchosen.';';
            //check adding child
            if(($currentyear-$childyear)>5)
            {
                // child over 5y
                if($childgt5adding->id!=null) {
                    $childgt5addingid[] = $childgt5adding->id;
                }
                $count++;
            } else {
                //child under 6y
                if($freechild<=0) {
                    if($childlt550adding->id!=null) {
                        $childlt550addingid[] = $childlt550adding->id;
                    }
                    $count++;
                } else {
                    if($childchosen) {
                        if($childlt5adding->id!=null) {
                            $childlt5addingid[] = $childlt5adding->id;
                        }
                        $count++;
                        //freechild need ?
                        //$freechild++;
                    }
                    $freechild--;
                }
            }
        }
        //////////////more addings id
        $moreaddingsid = array();
        $totalmoreadding = 0;
        foreach($moreaddings as $index => $value)
        {
            for($i=0;$i<$value['amount'];$i++){
                if($value['amount']!=''&&$value['amount']!='0') {
                    $moreaddingsid[] = $value['adding'] * 1;
                }
            }
            $adding = Adding::find($value['adding']);
            $totalmoreadding += ($adding->price)*$value['amount']*1;
            $count  = $count+($adding->addingcate->seat*$value['amount']);
        }
        //Create new Order
        $order->childlist = $childlist;
        $order->price = filter_var($inputs['starhotel'],FILTER_SANITIZE_NUMBER_FLOAT);
        $totaladult = $sellprice * (filter_var($inputs['soluong'],FILTER_SANITIZE_NUMBER_INT));
        $totalchild = (count($childgt5addingid)*$childgtsixprice)+(count($childlt550addingid)*$childltsix50price)+(count($childlt5addingid)*$childltsixprice);
        $total = $totaladult+$totalchild+$totalmoreadding;
        $order->total = $total;
        $order->deposit = $inputs['deposit'];
        $order->payment = $total-$order->deposit;
        //////////////adding
        $order->addingamount = $totalchild;
        $order->addingseat = $count;
        $meraddings = array_merge($childgt5addingid,$childlt550addingid,$childlt5addingid,$moreaddingsid);
        /////////////////////discount field
        //$olddiscount = $order->discount;
        //$order->discount = filter_var($inputs['discount'],FILTER_SANITIZE_NUMBER_INT);
        //$order->discount_reason = filter_var($inputs['discount_reason'],FILTER_SANITIZE_STRING);
        //////////////////////
        //$oldstatus = $order->status;
        $order->customer_id = filter_var($inputs['user'],FILTER_SANITIZE_NUMBER_INT);

        $order->tourstaff_id = $startdate->tour->user_id;

        $order->startdate_id = $startdate->id;
        $order->address = filter_var($inputs['address'],FILTER_SANITIZE_STRING);
        $order->adult = filter_var($inputs['soluong'],FILTER_SANITIZE_NUMBER_INT);$inputs['soluong'];
        if($this->auth->user()->id!=$startdate->tour->user_id) {
            $order->isBook = 1;
        } else {
            $order->isBook = 0;
        }



        /////////////Calculate discount  and customer point after discount
        //if( $inputs['discount']!='')
        //{
        //    $order->total = $order->total - $order->discount;
        //    if($isnew) {
        //        $customer->point = $customer->point - round(($order->discount/1000),0);
        //    } else {
        //        $discountchange = $olddiscount - $order->discount;
        //        if($discountchange<0){
        //            //dd( $customer->point.'--2----'.$discountchange);
        //            $customer->point = $customer->point + round(( $discountchange/1000),0);
        //        } else
        //        {
        //            $customer->point = $customer->point - round(( $discountchange/1000),0);
        //        }
        //        //dd( $customer->point.'--3----p'.$discountchange);
        //    }
        //}
        ////////////////// enter deal field
        //if($inputs['deal']!='')
        //{
        //    $order->deal = filter_var($inputs['deal'],FILTER_SANITIZE_STRING);
        //} else {
        //    $order->deal = '';
        //}
        ////////////// room struct field
        if($inputs['room']!='')
        {
            $order->room = filter_var($inputs['room'],FILTER_SANITIZE_STRING);
        } else {
            $order->room = '';
        }
        ////////////// room struct field
        if($inputs['notice']!='')
        {
            $order->notice = filter_var($inputs['notice'],FILTER_SANITIZE_STRING);
        } else {
            $order->notice = '';
        }
        /////////////////////////
        $order->save();
        //$customer->save();
        ///////////create adding many to many
        $order->addings()->detach();
        if (count($meraddings) > 0) {
            $order->addings()->attach($meraddings);
        }
        $backlink = $order->status == 0 ? 'agent/order' : 'agent/editorder/' . $order->id;
        //if($order->status == 0){
        //    $this->cancelAll($order);
        //}
        return redirect()->intended($backlink)->with('ok', $notice);
    }
    public function getSeat(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            if(is_numeric($inputs['id']))
            {
                $totalseat = 0;
                $startdate = StartDate::find($inputs['id']);
                // only confirm orders
                $orders = Order::where('status','>',1)->where('startdate_id','=',$startdate->id)->get();
                foreach($orders as $od)
                {
                    $totalseat +=  $od->adult+$od->addingseat;
                }
                return $totalseat.'/'.$startdate->seat;
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function showAdding(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        if($request->ajax())
        {
            if(is_numeric($request['id']))
            {
                $startdate = StartDate::find($request['id']);
                $noforcedaddings = $startdate->addings()->whereHas('addingcate',function($q) {
                    $q->where('isForced','=','0')->where('id','!=','2')->where('id','!=','3')->where('id','!=','5');
                })->get();
                return view('front.agent.partials.addings',compact('noforcedaddings'));
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
}
