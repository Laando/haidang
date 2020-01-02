<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Adding;
use App\Models\AddingCate;
use App\Models\Car;
use App\Models\Config;
use App\Models\Gift;
use App\Models\HotelBook;
use App\Models\MemberType;
use App\Models\Miscalculate;
use App\Models\MiscalculateAmount;
use App\Models\MiscalculateConsult;
use App\Models\Order;
use App\Models\Seat;
use App\Models\SendEmail;
use App\Models\StartDate;
use App\Models\Tour;
use App\Models\Traffic;
use App\Models\Transport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Guard;
use App\Models\DestinationPoint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
class StaffController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct(\Illuminate\Contracts\Auth\Guard $auth)
    {
        $expiresAt = Carbon::now()->addMinutes(10);
        $this->auth = $auth;
        $this->middleware('staff');
        $this->middleware('admin',['only'=>['doFinished']]);
        $staffs = User::where('role_id','like','2')->get();
        $eventtimeconfig = Config::where('type','like','golden-hour')->first();
        $this->eventtimeconfig = $eventtimeconfig;
        $vehicles = Cache::remember('vehicles', $expiresAt, function () {
            return \App\Models\Traffic::all();
        });
        View::share(compact('staffs','eventtimeconfig', 'vehicles'));
    }
	public function index(Request $request)
	{
        $user = Auth::user();
        $role = $user->role->slug;

        $destinationpoints =  DestinationPoint::orderBy('priority','ASC')->get();

            $staff = isset($request['staff'])&&$role!='admin'?$request['staff']:$user->id;
            $destinationpoint = $request['destinationpoint'];
            $startdate = $request['start'];
            $tours = Tour::where('status','=','1');

            if($staff != '' && is_numeric($staff)){
                $tours = $tours->where('user_id','=',$staff);
            }


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
            $tour_ids  = $tours->pluck('id');
            //dd($tour_ids);
            //$hasstartdates  = StartDate::where('startdate','>',new \DateTime())->pluck('startdate')->all();
            $hasstartdates  = StartDate::where('startdate','>',new \DateTime())->whereIn('tour_id',$tour_ids)->get();
            //dd($hasstartdates);
        //$arrtours = $user->tours()->pluck('id');
        //$startdates = StartDate::whereIn('tour_id',$arrtours)->where('startdate','>','now()')->orderBy('startdate','DESC')->get();
		return view('front.staff.index',compact(
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
        return view('front.staff.tour',compact(
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
        $queryarr = array();
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
            $queryarr['str'] = $str;
        }
        if($status!=''){
            $queryarr['status']= $status;
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
                $queryarr['start'] = $start;
                $dtstart = Carbon::createFromFormat('d/m/Y',$start);
                $orders = $orders->where('created_at','>=',Carbon::create($dtstart->year,$dtstart->month,$dtstart->day,0,0,0));
            }
            if($end!=''){//has start
                $queryarr['end'] = $end;
                $dtend = Carbon::createFromFormat('d/m/Y',$end);
                $orders = $orders->where('created_at','<=',Carbon::create($dtend->year,$dtend->month,$dtend->day,23,59,59));
            }

            //dd('â');
            //dd($orders);
            //dd(Carbon::create($dtend->year,$dtend->month,$dtend->day,23,59,59));
        } else {
            if(!($role=='admin')) {
                $orders = $orders->whereHas('startdate',function($q){
                    $dtyesterday = Carbon::yesterday();
                    $q->where('startdate','>=',$dtyesterday);
                    //dòng này mới thêm ngày 30-9-2015
                })->orWhere('status','=','1')->where('staff_id','=',$user->id);
            }
            //dd('b');
        }
        //dd($orders->toSql());
        $total = $orders->count();
        if($role!='admin'&&$given==null&&$status!='3'){
            $orders = $orders->where('status','!=',3);
            //dd($orders->get());
        }
        $orders = $orders->orderBy('status')->latest()->paginate($n);
        //dd($orders);
        $links = str_replace('/?', '?', $orders->appends($queryarr)->render());
        return view('front.staff.order',compact(
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
    public function customer()
    {
        $n = 20;
        $user = Auth::user();
        $tours = Tour::whereStatus(1)->latest()->get();
        $gifts = Gift::whereStatus(1)->orderBy('point','ASC')->get();
        $staffid = Input::get('staff');
        $tourid = Input::get('tour');
        $point = Input::get('point');
        $start = Input::get('start');
        $membertype = Input::get('member_card_type');
        $end = Input::get('end');
        $string = Input::get('string');
        $customers = User::where('role_id','=',3);
        if($staffid!='') {
            $staffid = filter_var($staffid , FILTER_SANITIZE_NUMBER_INT);
            $customers = $customers->whereHas('orders',function($q) use ($staffid) {
                   $q->where('tourstaff_id','=',$staffid);
            });
        }
        if($tourid!='') {
            $tourid = filter_var($tourid , FILTER_SANITIZE_NUMBER_INT);
            $customers = $customers->whereHas('orders',function($q) use ($tourid) {
                //$q->startdate()->where('tour_id','=',$tourid);
                $q->whereHas('startdate',function($qq) use ($tourid){
                    $qq->where('tour_id','=',$tourid);
                });
            });
        }

        if($point!='') {
            $point = filter_var($point , FILTER_SANITIZE_NUMBER_INT);
            $customers = $customers->where('point','>=',$point);

        }
        if(!($start==''&&$end==''))
        {
            if($start!=''){//has end
                $dtstart = Carbon::createFromFormat('d/m/Y',$start);
                $customers = $customers->whereHas('orders',function($q) use ($dtstart) {
                    $q->whereHas('startdate',function($qq) use ($dtstart){
                        $qq->where('startdate','>=',Carbon::create($dtstart->year,$dtstart->month,$dtstart->day,0,0,0));
                    });
                });
            }
            if($end!=''){//has start
                $dtend = Carbon::createFromFormat('d/m/Y',$end);
                $customers = $customers->whereHas('orders',function($q) use ($dtend) {
                    $q->whereHas('startdate',function($qq) use ($dtend){
                        $qq->where('startdate','>=',Carbon::create($dtend->year,$dtend->month,$dtend->day,23,59,59));
                    });
                });
            }
        }
        if($string!='') {
            $customers = $customers->where(function ($q) use($string){
                  $q->where('phone','like','%'.$string.'%')
                    ->orWhere('email','like','%'.$string.'%')
                    ->orWhere('username','like','%'.$string.'%')
                    ->orWhere('fullname','like','%'.$string.'%')
                    ->orWhere('member_card','like','%'.trim($string," ").'%');
            });
        }
        if($membertype!=''){
            $customers = $customers->where('member_card_type',$membertype);
        }
        $customers = $customers->latest()->paginate($n);
        $links = str_replace('/?', '?', $customers->render());
        $select_card_type = MemberType::all()->pluck('name', 'id');
        $select_card_type->prepend('None','0');
        return view('front.staff.customer',compact(
            'user',
            'tours',
            'customers',
            'gifts',
            'links',
            'select_card_type'
        ));
    }
    public function startdate($isPost = false , $tourid = null)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        if($role=='staff') {
            $destinationpoints = DestinationPoint::distinct()->whereHas('tours',function($q) use ($user){
                $q->where('user_id','like',$user->id);
            })->orderBy('title')->groupBy('title')->pluck('title','id')->all();
            $tours = Tour::where('status','=',1)->where('user_id','like',$user->id)->pluck('title','id')->all();
        } else {
            $destinationpoints = DestinationPoint::orderBy('title')->pluck('title','id')->all();
            $tours = Tour::all()->pluck('title','id')->all();
        }
        $destinationpoints = array('' => 'Tất cả điểm đến') + $destinationpoints;
            $inputs = Input::all();
            if($tourid!=null) $inputs['tour']= $tourid;
            if($role=='staff') {
                if(isset($inputs['tour'])){
                    $tour = Tour::where('status','=',1)->where('user_id', 'like', $user->id)->whereId($inputs['tour'])->firstOrFail();
                } else {
                    $tour = null;
                }

            } else {
                $tour = Tour::whereId($inputs['tour'])->firstOrFail();
            }
        $miscalculates = Miscalculate::all();
        return view('front.staff.startdate',compact(
            'user',
            'role',
            'destinationpoints',
            'tours',
            'tour',
            'miscalculates'
        ));
    }
    public function postStartdate($tourid = null)
    {
        return $this->startdate(true ,$tourid);
    }
    public function editOrder($isnew = null)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        //if(Input::get('create')=='new'&&$user->role->slug!='admin'){
        //    $tours = Tour::whereStatus(1)->where('user_id','=',$user->id)->latest()->get();
        //} else {
        if($user->role->slug!='admin'){
            $tours = Tour::whereStatus(1)->where('user_id','=',$user->id)->latest()->get();
        } else {
            $tours = Tour::whereStatus(1)->latest()->get();
        }

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
            if(Input::get('tourid')!=''&&is_numeric(Input::get('tourid')))
            {
                $tour = Tour::find(Input::get('tourid'));
                //$tours = Tour::whereStatus(1)->latest()->get();
            }
            $allstartdates =  array();
            $order = new Order();
            $order->id = '';

            return view('front.staff.orderedit',compact(
                'order',
                'user',
                'role',
                'useredit',
                'tours',
                'tour',
                'allstartdates',
                'startdates',
                'notice',
                'deals'
            ));
        }
        else
        {

            ///////edit order
            $id = $isnew;
            $order = Order::find($id);
            $startdate = $order->startdate;
            $tour  = Tour::find($startdate->tour_id);
            if($tour==null) {
                $messages = new MessageBag;
                $messages->add('StatusError', 'Tour đã bị xóa !');
                return  redirect()->intended('staff/neworder')->withErrors($messages)->with('StatusError','fail');
            } else {
                $exist_tour  =  $tours->filter(function($value,$key) use ($tour){
                    return $value->id  === $tour->id;
                });
                if(count($exist_tour)=== 0 ){
                    $tours->prepend($tour);
                }
            }
            if($user->role->slug!='admin') {
                if ($user->id != $order->tourstaff_id)
                {
                    //$messages = new MessageBag;
                    //$messages->add('StatusError', 'Bạn không có quyền này ! Vui lòng liên hệ '.$order->tourstaff->fullname);
                    //return  redirect()->intended('staff/neworder')->withErrors($messages)->with('StatusError','fail');
                }
                if($order->status == 0)
                {
                    $messages = new MessageBag;
                    $messages->add('StatusError', 'Đơn hàng đã hủy không thể chỉnh sửa');
                    return  redirect()->intended('staff/neworder')->withErrors($messages)->with('StatusError','fail');
                }
            }

            $useredit = User::find($order->customer_id);
            $timenow = Carbon::now();
            $currentstartdate = $order->startdate;
            $timecheck = Carbon::createFromFormat('Y-m-d',$currentstartdate->startdate);
            if($timenow->diffInHours($timecheck, false)<0) {
                $allstartdates = StartDate::where('tour_id','=',$currentstartdate->tour_id)->orderBy('startdate', 'ASC')->get();
            } else {
                $allstartdates = StartDate::where('startdate', '>=', $order->startdate->startdate)->where('tour_id','=',$currentstartdate->tour_id)->orderBy('startdate', 'ASC')->get();
            }
            /////////////here
            $transports = $order->startdate->transports()->get();
            $transport = $transports->first();

            $currentseat = 0;
            $sseat = array();
            if($transport !=null) {
                $currentseat = $transport->seats()->where('order_id', 'like', $order->id)->count();
                $sseat = $transport->seats()->where('order_id', 'like', $order->id)->pluck('number')->all();
                $notice = '';
            } else {
                $notice = 'Chưa tạo xe';
            }


            return view('front.staff.orderedit',compact(
                'order',
                'user',
                'role',
                'useredit',
                'tours',
                'transports',
                'transport',
                'notice',
                'sseat',
                'currentseat',
                'tour',
                'allstartdates',
                'startdates',
                'deals'
            ));
        }
    }
    public function newOrder()
    {
        return $this->editOrder('true');
    }
    public function startdateCreate()
    {
            $user = Auth::user();
            $inputs = Input::all();
            //create startdate
            $strstardate = $inputs['startdate'];
            $arrstartdate = explode(', ',$strstardate);
            //dd($arrstartdate);
            $seat = $inputs['seat'];
            $is_bed = isset($inputs['is_bed'])?$inputs['is_bed']:0;
            $traffic = $inputs['traffic'];
            $tour_id = $inputs['tourid'];
            $tour = Tour::find($tour_id);
        if($user->id == $tour->user->id || $user->role->slug == 'admin') {
            foreach($arrstartdate as $stardate) {
                if($this->checkExistStartdate(Carbon::createFromFormat('d/m/Y', $stardate),$tour)) {
                    $num_seat = 45;
                    if($is_bed){
                        $num_seat = 40;
                    }
                    $totaltransport = intval(round($seat / $num_seat));

                    $objstartdate = new StartDate();
                    $objstartdate->startdate = Carbon::createFromFormat('d/m/Y', $stardate);
                    $objstartdate->seat = $totaltransport*$num_seat;
                    $objstartdate->traffic = $traffic;
                    $objstartdate->tour_id = $tour_id;
                    $objstartdate->save();
                    //create adding
                    $addingcates = $inputs['addingcate'];
                    $prices = $inputs['price'];
                    foreach ($addingcates as $index => $value) {
                        $adding = new Adding();
                        $adding->addingcate_id = $addingcates[$index];
                        $adding->price = $prices[$index];
                        $adding->startdate_id = $objstartdate->id;
                        $adding->save();
                    }
                    /////////////calculate transports
                    for ($i = 0; $i < $totaltransport; $i++) {
                        $transport = new Transport();
                        $transport->startdate_id = $objstartdate->id;
                        $transport->save();
                        $this->createSeat($transport->id);
                    }
                }
            }
                ///////////////////////////////////////
            $data = array();
            $data['status'] = 1;
            $data['message'] = 'Thêm mới ngày khởi hành thành công';
        } else {
            $data = array();
            $data['status'] = 0;
            $data['message'] = 'Bạn không có quyền này';
        }
        echo json_encode($data);
    }
    public function startdateEdit()
    {
        $data = array();
        $user = Auth::user();
        $inputs = Input::all();
        $stardate = $inputs['startdate'];
        $seat = $inputs['seat'];
        $traffic = $inputs['traffic'];
        $tour = StartDate::find($inputs['startdateid'])->tour;
        if($user->id == $tour->user->id || $user->role->slug == 'admin')
        {
            $objstartdate = StartDate::find($inputs['startdateid']);
            // total transport seat
            $transports  =  $objstartdate->transports;
            $total_old_transport_seats = 0;
            foreach($transports as $transport){
                $num  =$transport->seats->count();
                $total_old_transport_seats += $num;
            }
            /////////old transport
            $oldseat = $objstartdate->seat;
            $oldtotaltransport = intval(round($objstartdate->seat/45));
            //////////////////
            if($user->role->slug=='admin')  $objstartdate->startdate = Carbon::createFromFormat('d/m/Y', $stardate);
            $objstartdate->seat = $seat;
            $objstartdate->traffic = $traffic;
            $objstartdate->save();
            //edit old adding
            if(isset($inputs['oldaddingid'])) {
                $addingcates = $inputs['oldaddingcate'];
                $prices = $inputs['oldprice'];
                $addingid = $inputs['oldaddingid'];
                foreach ($addingcates as $index => $value) {
                    $adding = Adding::find($addingid[$index]);
                    $addinguser = $adding->startdate->tour->user;
                    if ($user->id == $addinguser->id || $user->role->slug == 'admin') {
                        $adding->addingcate_id = $addingcates[$index];
                        $adding->price = $prices[$index];
                        $adding->save();
                    }
                }
            }
            if(isset($inputs['price'])) {
                //create adding
                $addingcates = $inputs['addingcate'];
                $prices = $inputs['price'];
                foreach ($addingcates as $index => $value) {
                    $adding = new Adding();
                    $adding->addingcate_id = $addingcates[$index];
                    $adding->price = $prices[$index];
                    $adding->startdate_id = $objstartdate->id;
                    $adding->save();
                }
            }
            /////////////calculate transports
            $newtotaltransport = intval(round($seat/45));
            if($seat>$total_old_transport_seats){
                $newtransport = intval(($seat-$total_old_transport_seats)/45 );
                for($i=0;$i<$newtransport;$i++)
                {
                    $transport = new Transport();
                    $transport->startdate_id = $objstartdate->id;
                    $transport->save();
                    $this->createSeat($transport->id);
                }
            }
            if($seat<$total_old_transport_seats){
                $decrease_seat = ($total_old_transport_seats-$seat);
                $transports = Transport::where('startdate_id','like',$objstartdate->id)->latest()->get();
                if($transports->count()> 0){
                    $first_transport = $transports->first() ;
                    $step_count = $first_transport->seats->count() ;
                    $i = 0 ;
                    do {
                        foreach($transports_tmp = $transports as $index=>$transport){
                            $emptytransport =  $transport->seats()->whereNotNull('order_id')->count();
                            if($emptytransport == 0)
                            {
                                $total_old_transport = $transport->seats->count();
                                if(($decrease_seat - $total_old_transport)>0){
                                    $transport->delete();
                                    $step_count = $transport->seats->count();
                                    //unset($transports[$index]);
                                    //$transports = array_values($transports);
                                    $decrease_seat = $decrease_seat - $total_old_transport;
                                }
                            }
                            else
                            {
                                $data = array();
                                $data['status'] = 0;
                                $data['message'] = 'Cảnh báo : Xóa xe có chỗ !';
                                break;
                            }
                        }
                        $i ++;
                    } while ($decrease_seat >= $step_count || $i >20);
                }
            }
            if(!isset($data['status'])) {
                $data['status'] = 1;
                $data['message'] = 'Cập nhật ngày khởi hành thành công !';
            }
            // correct startdate seat
            $startdate = StartDate::find($inputs['startdateid']);
            $transports  = $startdate->transports;
            $total_old_seat =  0 ;
            foreach($transports as $tran){
                $total_old_seat += $tran->seats()->count();
            }
            $startdate->seat =  $total_old_seat ;
            $startdate->save();
        } else
        {
            $data['status'] = 0;
            $data['message'] = 'Bạn không có quyền này';
        }
        echo json_encode($data);
    }
    public function changeTransportType(Request $request){
        $user = Auth::user();
        $role = $user->role->slug;
        if($request->ajax())
        {
            if(is_numeric($request['id']))
            {
                $transport  = Transport::find($request['id']);
                $transport->is_bed = $request['type'];
                $seats = $transport->seats()->orderBy('number')->get();
                $diff_value = 0;
                $startdate = $transport->startdate;
                $transports  = $startdate->transports;
                $total_old_seat =  0 ;
                foreach($transports as $tran){
                    $total_old_seat += $tran->seats()->count();
                }
                DB::beginTransaction();
                try {
                if($transport->is_bed){
                    if($seats->count()>40){
                        //Xóa
                        foreach($seats as $index=>$seat){
                            if($index>39 && $seat->order_id == null){
                                $seat->delete();
                                $diff_value --;
                            }
                        }
                    }
                } else {
                    if($seats->count()<45){
                        $arr_num = array();
                        $arr_num_lost = array();
                        foreach($seats as $seat){
                            $arr_num[intval($seat->number)] = true;
                        }
                        for($i=1;$i<=45;$i++){
                            if(!isset($arr_num[$i])) {
                                $arr_num_lost[] = $i;
                            }
                        }
                        foreach($arr_num_lost as $num){
                            $seat = new Seat();
                            $seat->transport_id = $transport->id;
                            $seat->number = $num ;
                            $seat->save();
                            $diff_value++;
                        }
                    }
                }
                $rs = $transport->save();

                //$startdate->seat  = $startdate->seat + $diff_value ;
                $startdate->seat  = $total_old_seat + $diff_value;
                $startdate->save();
                $data = array();
                $data['status'] = 1;
                $data['message'] = 'Thay đổi thành công !';
                $data['total_seat'] = $startdate->seat;
                } catch(\Exception $e){
                    DB::rollback();
                    $data = array();
                    $data['status'] = 0;
                    $data['message'] = 'Có lỗi vui lòng liên hệ admin !';
                    $data['total_seat'] = $startdate->seat;
                }
                DB::commit();
                echo json_encode($data);
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
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
                return view('front.staff.partials.addings',compact('noforcedaddings'));
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
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
            if($username == '') {
                $username = $request->phone;
            }
            $email = $request->email;
            $phone = $request->phone;
            $fullname = $request->fullname;
            $password = $request->password;
            $gender = $request->gender;
            $address = $request->address;
            $users = User::where('role_id','=',3)->where(function($query) use ($email){
                $query->where('email','!=','');
                $query->where('email','like',$email);
            })->orWhere('phone','like',$phone)->get();
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
    public function createOrder(Request $request)
    {
        $eventtime =  Carbon::createFromFormat('Y-m-d H:i:s', $this->eventtimeconfig->content);
        $eventtimeend =  $eventtime->copy()->addHour(2);
        $now = Carbon::now();
        $inEvent = $now->between($eventtime, $eventtimeend);
        $oldtotal = 0;
        $flagadmin = 0;
        $isnew = true;

        ////////////////////////////valid createOrder reuqest
        $currentyear = date('Y');
        $minyear = $currentyear - 10;
        $messages = array(
            'required' => ':attribute không được để trống',
            'numeric' => ':attribute phải là số',
            'exists' => ':attribute không tồn tại',
        );
        $inputs = Input::all();
        $inputs['deposit'] = $inputs['deposit']?$inputs['deposit']:'0';
        $inputs['discount'] = $inputs['discount']?$inputs['discount']:'0';
        $validator = Validator::make($inputs, [
            'user' => 'required|numeric|exists:users,id',
            'selectedstartdate' => 'required|numeric|exists:start_dates,id',
            'adult' => 'required|numeric',
            'child' => 'numeric',
            'baby' => 'numeric',
            'deposit' => 'numeric',
            'discount' => 'numeric'
        ], $messages);
        $niceNames = array(
            'user' => 'Khách hàng',
            'selectedstartdate' => 'Ngày khởi hành',
            'adult' => 'Số người lớn',
            'child' => 'Số trẻ em',
            'baby' => 'Số em bé',
            'deposit' => 'Tiền cọc',
            'discount'=> 'Giảm giá'
        );
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
        if(is_numeric($request['id']) && $request['id']!=='0')
        {
            $order = Order::find($request['id']);
            $oldtotal = $order->total;
            $oldstartdate = $order->startdate->id;
            $notice = "Cập nhật đơn hàng thành công";
            $customer = $order->customer;
            $isnew = false;
        }    else {
            $order = new Order();
            $notice = 'Tạo mới đơn hàng thành công !';
            $customer = User::find($inputs['user']);
            ////////////set order for the staff that working with customer
            $order->staff_id = $this->auth->user()->id;
            $startdate = StartDate::find($inputs['selectedstartdate']);
            $order->startdate = $startdate;
            $order->startdate_id = $startdate->id;
            $order->online = 0;
        }
        //Calculate ADDINGS
        $startdate = StartDate::find($inputs['selectedstartdate']);
        $isGold = $startdate->tour->isGolden();
        if($isnew) {
            $tickets = $startdate->countPromotionCode();
        } else {
            $tickets = $order->promotion_codes()->count();
        }
        if($this->auth->user()->role->slug=='admin'||$this->auth->user()->id==$startdate->tour->user_id)
        {

        } else {
            if($startdate->isEnd){
                $messages = new MessageBag;
                $messages->add('StatusError', 'Không nhận thêm khách cho ngày khởi hành này vui lòng liên hệ người quản lý tour');
                return  redirect()->back()->withErrors($messages)->with('StatusError','fail');
            }
        }
        $order->adult = $inputs['adult'];
        $order->child = $inputs['child'];
        $order->baby = $inputs['baby'];
        if($inputs['deposit']*1 !== 0 && !$isnew) {
            $order->deposit = $inputs['deposit'];
            $order->datedeposit = Carbon::now();
        }


        $olddiscount = $order->discount;
        $olddiscountgold = $order->discountgold;
        $oldstatus = $order->status;

        // cập nhật startdate
        $order->startdate = $startdate;
        ////////
        $order->deal = isset($inputs['deal'])?filter_var($inputs['deal'],FILTER_SANITIZE_STRING):'';
        $order->room = isset($inputs['room'])?filter_var($inputs['room'],FILTER_SANITIZE_STRING):'';
        $order->notice =  isset($inputs['notice'])?filter_var($inputs['notice'],FILTER_SANITIZE_STRING):'';
        $order->discount = isset($inputs['discount'])?filter_var($inputs['discount'],FILTER_SANITIZE_NUMBER_INT):0;
        $order->discountgold = isset($inputs['discountgold'])?filter_var($inputs['discountgold'],FILTER_SANITIZE_NUMBER_INT):0;
        $order->discount_reason = isset($inputs['discount_reason'])?filter_var($inputs['discount_reason'],FILTER_SANITIZE_STRING):0;
        $rtn_obj = $this->CalcualateOrderTotal($order,$inputs);
        $order->total = $rtn_obj->total;
        //dd($order->total ,$order->deposit , $order->discountgold ,$order->discount );
        // tổng số tiền khách phải trả  = tổng số tiền - số tiền cọc - sô tiền giảm giá giờ vàng - số tiền giảm giá
        $order->payment = $order->total - $order->deposit - $order->discountgold - $order->discount;


        $order->customer_id = $inputs['user'];
        $order->seat = $order->adult*1 + $order->child*1 ; // + thêm số ghế mua
        if($this->auth->user()->role->slug=='admin') {
        //////////////////isAdmin
            if($inputs['staff']!='') {
                $order->staff_id = $inputs['staff'];
            } else {
                $order->staff_id = $startdate->tour->user_id;
            }
            $order->status = $inputs['status'];

            if($order->status==2)
            {
                    if($isnew) {
                        $customer->point = $customer->point + round(($order->total) / 1000, 0);
                    }  else {
                        if($oldstatus <2)
                        {
                            $customer->point = $customer->point + round(($order->total) / 1000, 0);
                        } else
                        {

                            $customer->point = $customer->point + (round(($order->total) / 1000, 0)- round(($oldtotal) / 1000, 0)- round(($olddiscount) / 1000, 0));
                        }
                    }
                $flagadmin = 1;
                $order->approve_date = Carbon::now();
            }

        } else {
        //////////////////////////////isNot ADMIN
            if($order->status>2){
                $messages = new MessageBag;
                $messages->add('StatusError', 'Đơn hàng đã hoàn tất không thể chỉnh sửa');
                return  redirect()->back()->withErrors($messages)->with('StatusError','fail');
            }

            if ($order->deposit != 0 || $order->status == 2) {
                if($isnew) {
                    $customer->point = $customer->point + round(($order->total) / 1000, 0);
                }  else {
                    if($oldstatus <2)
                    {
                        $customer->point = $customer->point + round(($order->total) / 1000, 0);
                    } else
                    {
                        $customer->point = $customer->point + (round(($order->total) / 1000, 0)- round(($oldtotal) / 1000, 0)- round(($olddiscount) / 1000, 0));
                    }
                }
                $order->approve_date = Carbon::now();
            } else {
                $order->status = 1;
            }
        }
        $order->tourstaff_id = $startdate->tour->user_id;
        ///////////// remove seat on change startdate
        if(is_numeric($request['id'])&& $request['id']!=='0') {
            if ($oldstartdate != $startdate->id) {
                $seats = Seat::where('order_id','=',$order->id)->get();
                foreach($seats as $se){
                    $se->order_id = null;
                    $se->save();
                }
            }
        }
        $order->startdate_id = $startdate->id;
        $order->address = $inputs['address'];
        if($this->auth->user()->id!=$startdate->tour->user_id) {
            $order->isBook = 1;
        } else {
            $order->isBook = 0;
        }
        /////////////Confirm state ///       lỗi order Văn Nhật Phương
        if(isset($request['confirmOrder'])&&$order->status!=2)
        {
            if(Carbon::createFromFormat('Y-m-d',$order->startdate->startdate) >= Carbon::now()) {
                $order->status = 2;
            }
            if($flagadmin!=1) {
                if ($isnew) {
                    $customer->point = $customer->point + round(($order->total) / 1000, 0);
                } else {
                    if ($oldstatus < 2) {
                        $customer->point = $customer->point + round(($order->total) / 1000, 0);
                    } else {
                        $customer->point = $customer->point + (round(($order->total) / 1000, 0) - round(($oldtotal) / 1000, 0));
                    }
                }
            }
            $order->approve_date = Carbon::now();
            $notice = 'Đơn hàng xác nhận thành công';
        }

        if(isset($request['cancelOrder']))
        {
            if($this->auth->user()->role->slug=='admin'||$this->auth->user()->id==$order->tourstaff->id) {
                $order->discountgold = 0;
                $order->status = 0;
                $notice = 'Hủy đơn hàng thành công';
                if ($oldstatus > 1) {
                    $customer->point = $customer->point - round(($oldtotal) / 1000, 0);
                }
            }
        }
        if($order->id=='')
        {

        } else {
            if($this->auth->user()->role->slug=='admin'||$this->auth->user()->id==$order->tourstaff->id) {

            } else {
                if($oldstatus <2 && $order->status <2) {

                } else {
                    $messages = new MessageBag;
                    $messages->add('StatusError', 'Bạn không có quyền này');
                    return redirect()->back()->withErrors($messages)->with('StatusError', 'fail');
                }
            }
        }
        /////////////Calculate discount goldpoint  and customer point after discount
        if( $inputs['discountgold']!='')
        {
            if($inEvent&&$isGold) {
                if ($isnew) {
                    $customer->point = $customer->point - round(($order->discountgold / 1000), 0);
                } else {
                    $discountchange = $olddiscountgold - $order->discountgold;
                    if ($discountchange < 0) {
                        $customer->point = $customer->point + round(($discountchange / 1000), 0);
                    } else {
                        $customer->point = $customer->point - round(($discountchange / 1000), 0);
                    }
                }
            }
        }
        /////////////Calculate discount  and customer point after discount
        if( $inputs['discount']!='')
        {
            //$order->total = $order->total - $order->discount;
            if($isnew) {
                $customer->point = $customer->point - round(($order->discount/1000),0);
            } else {
                $discountchange = $olddiscount - $order->discount;
                if($discountchange<0){
                    $customer->point = $customer->point + round(( $discountchange/1000),0);
                } else
                {
                    $customer->point = $customer->point - round(( $discountchange/1000),0);
                }
            }
        }
        //// render addings json field
        $order->addings = \GuzzleHttp\json_encode($rtn_obj->order_addings);
        ////Begin transaction

        DB::beginTransaction();
        try {
            /////////////////////////
            if($order->id == '0' || $order->id == ''){
                unset($order->startdate);
                $order->address = isset($order->address)?$order->address:'';
            }
            $order->save();
            $customer->save();
            $backlink = $order->status == 0 ? 'staff/order' : 'staff/editorder/' . $order->id;
            if ($order->status == 0) {
                $this->cancelAll($order);
            }
            ///////////create promotioncode for order
            if ($inEvent && $isGold) {
                $codes = $startdate->promotion_codes()->whereNull('order_id')->get();
                if ($inputs['soluong'] <= $tickets) {
                    foreach ($codes as $key => $code) {
                        if ($key < $inputs['soluong'] && $code->order_id == null) {
                            $code->order_id = $order->id;
                            $code->save();
                        }
                    }
                } else {
                    foreach ($codes as $key => $code) {
                        if ($key < $tickets && $code->order_id == null) {
                            $code->order_id = $order->id;
                            $code->save();
                        }
                    }
                }
            }
        } catch(\Exception $e){
            if($order->id == '0' || $order->id == ''){
                $backlink = 'staff/neworder?create=new';
            }
            DB::rollback();
            return redirect()->intended($backlink)->with('fail', $e);
        }
        DB::commit();
        return redirect()->intended($backlink)->with('ok', $notice);
    }
    function cancelAll($order)
    {
        $seats = Seat::where('order_id','=',$order->id)->get();
        foreach($seats as $seat){
            $seat->order_id = null;
            $seat->fullname = null;
            $seat->phone = null;
            $seat->save();
        }
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
                if($startdate->isEnd){
                    return '<span style="color:red">'.$totalseat.'/'.$startdate->seat.'</span>';
                } else {
                    return $totalseat.'/'.$startdate->seat;
                }
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function getTransportSeat(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            if(is_numeric($inputs['id']))
            {
                $notice = '';
                $order = Order::find($inputs['oid']);
                $transport = Transport::find($inputs['id']);
                $transports = Transport::where('startdate_id','like',$transport->startdate->id)->get();
                $currentseat = Seat::where('order_id','like',$order->id)->count();
                $sseat = $transport->seats()->where('order_id','like',$order->id)->pluck('number')->all();
                return view('front.staff.partials.transportmap',compact('transport','transports','order','currentseat','notice','sseat'));
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function setSeat(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            $user = $this->auth->user();
            if(is_numeric($inputs['sid'])&&is_numeric($inputs['oid'])) {
                $order = Order::find($inputs['oid']);
                if ($order->tourstaff_id == $user->id||$user->role->slug=='admin') {
                    $transport = Transport::find($inputs['ctransport']);
                    $transports = Transport::where('startdate_id', 'like', $transport->startdate->id)->get();
                    $currentseat = Seat::where('order_id', 'like', $order->id)->count();
                    ///////////////set order_id to seat
                    $notice = '';
                    if ($order->status < 3) {
                        if ($inputs['action'] == 'add') {
                            if ($currentseat < $order->adult + $order->addingseat) {
                                $seat = $transport->seats()->whereNumber($inputs['sid'])->first();
                                $seat->order_id = $order->id;
                                $seat->fullname = $order->customer->fullname;
                                $seat->phone = $order->customer->phone;
                                $seat->save();
                                $currentseat = $transport->seats()->where('order_id', 'like', $order->id)->count();
                            } else {
                                $notice = "Hết chỗ cho đơn hàng này !";
                            }
                        } else {
                            $seat = $transport->seats()->whereNumber($inputs['sid'])->first();
                            $seat->order_id = null;
                            $seat->fullname = null;
                            $seat->phone = null;
                            $seat->save();
                            $currentseat = $transport->seats()->where('order_id', 'like', $order->id)->count();
                        }
                    } else {
                        $notice = "Đơn hàng hoàn tất không thể chỉnh sửa !";
                    }
                    $sseat = $transport->seats()->where('order_id', 'like', $order->id)->pluck('number')->all();
                    return view('front.staff.partials.transportmap', compact('transport', 'transports', 'order', 'currentseat', 'notice', 'sseat'));
                }
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function showSeat($isPost = false)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        $transport = null;
        $transports = null;
        if($role=='staff') {
            $tours = Tour::where('status','=',1)->where('user_id','like',$user->id)->pluck('title','id')->all();
        } else {
            $tours = Tour::all()->pluck('title','id')->all();
        }
        $tours = array('' => 'Chọn tour') + $tours;
        $transport_id = Input::get('transport');
        if($transport_id!=''){
            $transport_id = filter_var($transport_id,FILTER_SANITIZE_NUMBER_INT);
            $transport = Transport::find($transport_id);
            $transports = $transport->startdate->transports()->get();
            $seats = Seat::where('transport_id','like',$transport->id)->orderBy('number','asc')->get();
        }
        return view('front.staff.seat',compact(
            'user',
            'role',
            'isPost',
            'tours',
            'transport',
            'transports',
            'seats'
        ));
    }
    public function getTransportList(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            if(is_numeric($inputs['sid']))
            {
                $startdate = StartDate::find($inputs['sid']);
                $transports = $startdate->transports()->get();
                return view('front.staff.partials.transportresult',compact('transports'));
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function getSeatList(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            if(is_numeric($inputs['id']))
            {
                $transport = Transport::find($inputs['id']);
                $seats = Seat::where('transport_id','like',$transport->id)->orderBy('number','asc')->get();
                $priority = $inputs['order'];
                return view('front.staff.partials.seatlist',compact('seats','priority','transport'));
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function updateSeatInfor(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            $user = $this->auth->user();
            if(is_numeric($inputs['group'])&&is_numeric($inputs['seat']))
            {
                $order = Order::find($inputs['group']);
                $is_outbound  = $order->startdate->tour->isOutbound ;
                if($order->tourstaff_id==$user->id||$user->role->slug=='admin') {
                    $seat = Seat::where('order_id', '=', $order->id)->where('number', '=', $inputs['seat'])->first();
                    $seat->fullname = $inputs['fullname'];
                    $seat->phone = $inputs['phone'];
                    $seat->DOB = $inputs['dob'];
                    $seat->dealcode = $inputs['dealcode'];
                    $seat->ppno = $inputs['ppno'];
                    $seat->ppexpired = $inputs['ppexpired'];
                    $seat->cmnd = $inputs['cmnd'];
                    $seat->save();
                    return view('front.staff.partials.updateseat', compact('order', 'seat' , 'is_outbound'));
                }
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function swapSeat(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            $user = $this->auth->user();
            if(is_numeric($inputs['id']))
            {
                $transport = Transport::find($inputs['id']);
                $arr_convert_bed = [
                    1 =>'A1',2 =>'A2',3 =>'B1',4 =>'B2',5 =>'C1',6 =>'C2',
                    7 =>'A3',8 =>'A4',9 =>'B3',10 =>'B4',11 =>'C3',12 =>'C4',
                    13 =>'A5',14 =>'A6',15 =>'B5',16 =>'B6',17 =>'C5',18 =>'C6',
                    19 =>'A7',20 =>'A8',21 =>'B7',22 =>'B8',23 =>'C7',24 =>'C8',
                    25 =>'A9',26 =>'A10',27 =>'B9',28 =>'B10',29 =>'C9',30 =>'C10',
                    31 =>'D1',32 =>'D2',33 =>'D3',34 =>'D4',35 =>'D5',
                    36 =>'D6',37 =>'D7',38 =>'D8',39 =>'D9',40 =>'D10'
                ];

                if($transport->startdate->tour->user_id==$user->id||$user->role->slug=='admin') {
                    $sourceseat_id  = $inputs['sourceseat'];
                    $destinationseat_id = $inputs['destinationseat'];
                    if($transport->is_bed){
                        foreach($arr_convert_bed as $index=>$item) {
                            if($sourceseat_id==$item){
                                $sourceseat_id = $index ;
                            }
                            if($destinationseat_id==$item){
                                $destinationseat_id = $index ;
                            }
                        }
                    }
                    $sourceseat = Seat::where('transport_id', '=', $transport->id)->where('number', '=', $sourceseat_id)->first();
                    $destinationseat = Seat::where('transport_id', '=', $transport->id)->where('number', '=', $destinationseat_id)->first();
                    if ($sourceseat->order_id == null && $destinationseat->order_id == null) return 'Chỗ trống cũng đổi nữa sao ...';
                    if ($sourceseat->number == $destinationseat->number) return '2 chỗ giống nhau !';
                    $numtemp = $sourceseat->number;
                    $sourceseat->number = $destinationseat->number;
                    $destinationseat->number = $numtemp;
                    $sourceseat->save();
                    $destinationseat->save();
                    return 'ok';
                }
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function updateNote(Request $request)
    {
        if($request->ajax())
        {
            $user = $this->auth->user();
            $inputs = Input::all();
                $transport = Transport::find($inputs['id']);
            if($transport->startdate->tour->user_id==$user->id||$user->role->slug=='admin') {
                $transport->guide = $inputs['guide'];
                $transport->phoneguide = $inputs['phoneguide'];
                $transport->note = $inputs['note'];
                $transport->save();
                return 'ok';
            } else {
                return 'fail';
            }
        } else {
            return 'fail';
        }
    }
    public function giftList(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            $customerid = $inputs['customerid'];
            $customers = User::where('role_id','=',3)->whereIn('id',$customerid)->orderBy('point','ASC')->get();
            $customer = User::where('role_id','=',3)->whereIn('id',$customerid)->orderBy('point','ASC')->first();
            $gifts = Gift::where('point','<=',$customer->point)->orderBy('point','ASC')->get();
            return view('partials.giftlist',compact('gifts','customers','customer'));
        } else {
            return 'fail';
        }
    }
    public function giftHistory(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            $customerid = $inputs['id'];
            $customer = User::find($customerid);
            return view('partials.gifthistory',compact('customer'));
        } else {
            return 'fail';
        }
    }
    public function endStartdate(Request $request){
        if($request->ajax()) {
            $inputs = Input::all();
            $id = $inputs['id'];
            $status = $inputs['status'];
            if (is_numeric($id)) {
                $user = $this->auth->user();
                $startdate = StartDate::find($id);
                if($user->role->slug =='admin' || $user->id == $startdate->tour->user_id ) {
                    $startdate->isEnd = $status;
                    $startdate->save();
                    return 'true';
                }
            }
        }
        return 'fail';
    }
    public function customerOrder(Request $request)
    {
        if($request->ajax())
        {
            $inputs = Input::all();
            $customerid = $inputs['id'];
            $customer = User::find($customerid);
            return view('partials.customerorder',compact('customer'));
        } else {
            return 'fail';
        }
    }
    public  function  updateGift (Request $request)
    {
        if($request->ajax())
        {
            $user = $this->auth->user();
            if($user->role->slug =='admin') {
                $inputs = Input::all();
                $customerid = $inputs['customerid'];
                $amount = $inputs['amount'];
                $point = $inputs['point'];
                $gift = Gift::where('point','=',$point)->first();
                $customers = User::where('role_id', '=', 3)->whereIn('id', $customerid)->orderBy('point', 'ASC')->get();
                foreach($customers as $customer)
                {
                    $customer->point = ($customer->point)-($point*$amount);
                    $customer->gifts()->attach($gift->id,array('amount' => $amount,'create_at'=>Carbon::now()));
                    $customer->save();
                }
                return 'ok';
            }
            return 'fail';
        } else {
            return 'fail';
        }
    }
    public function printTransportList(Request $request){
            $user = $this->auth->user();
            $arr_convert_bed = [
                1 =>'A1',2 =>'A2',3 =>'B1',4 =>'B2',5 =>'C1',6 =>'C2',
                7 =>'A3',8 =>'A4',9 =>'B3',10 =>'B4',11 =>'C3',12 =>'C4',
                13 =>'A5',14 =>'A6',15 =>'B5',16 =>'B6',17 =>'C5',18 =>'C6',
                19 =>'A7',20 =>'A8',21 =>'B7',22 =>'B8',23 =>'C7',24 =>'C8',
                25 =>'A9',26 =>'A10',27 =>'B9',28 =>'B10',29 =>'C9',30 =>'C10',
                31 =>'D1',32 =>'D2',33 =>'D3',34 =>'D4',35 =>'D5',
                36 =>'D6',37 =>'D7',38 =>'D8',39 =>'D9',40 =>'D10'
            ];
            if($user->role->slug =='admin'||$user->role->slug =='staff') {
                $inputs = Input::all();
                $transport  = Transport::find($inputs['id']);
                $path = app_path();
                $tour = $transport->startdate->tour;
                $startdate = ' '.date_format(date_create($transport->startdate->startdate),'d/m/Y').' ';
                $seats = Seat::where('transport_id','=',$transport->id)->whereNotNull('order_id')->orderBy('order_id','ASC')->orderBy('number','ASC')->get();
                $price = numbertomoney($transport->startdate->tour->adultprice);
                $staff = $transport->startdate->tour->user;
                if($tour->isOutbound){
                    $path_str = $path.'/File/'.'DANHSACHNN.xlsx';
                } else {
                    $path_str = $path.'/File/'.'DANHSACH.xlsx';
                }
                Excel::load($path_str, function($file) use ($tour,$price,$seats,$startdate,$staff,$transport,$arr_convert_bed ) {
                    $file->sheet('Sheet1', function($sheet) use($tour,$price,$seats,$startdate,$staff,$transport ,$arr_convert_bed){
                        $sheet->row(1, array(
                            'DANH SÁCH KHỞI HÀNH TOUR CÔNG TY CỔ PHẦN XÂY DỰNG DU LỊCH HẢI ĐĂNG','','','','','','','','','','NGÀY :'.$startdate
                        ));
                        $sheet->row(2, array(
                            $tour->title,'','','','','NGƯỜI PHỤ TRÁCH ','','',$staff->fullname,'',$staff->phone
                        ));
                        $sheet->row(3, array(
                            'Giá : '.$price,'','THỜI GIAN : '.$tour->period,'','','HƯỚNG DẪN VIÊN','','', $transport->guide ,'',$transport->phoneguide
                        ));
                        $preseat = null;
                        $children = 0;
                        foreach($seats as $index=>$seat)
                        {
                            if($this->isChild($seat->DOB)) $children++;
                            if($preseat==null)
                            {
                                $countseat = Seat::where('order_id','=',$seat->order_id)->count();
                                $sheet->mergeCells('F'.($index+5).':F'.($index+5+$countseat-1));
                                $sheet->mergeCells('K'.($index+5).':K'.($index+5+$countseat-1));
                                $sheet->cells('A'.($index+5).':J'.($index+5), function($cells) {
                                    //$cells->setBorder('solid', 'solid', 'solid', 'solid');
                                    $cells->setFont(array(
                                        'bold'       =>  true,
                                    ));
                                    //$cells->setBackground('#DDDDDD');

                                });
                                $arr_row =  array(
                                    $index+1,$seat->fullname,
                                    $seat->DOB,
                                    $this->isChild($seat->DOB)==true?'x':'',
                                    $transport->is_bed?$arr_convert_bed[$seat->number]:$seat->number,
                                    $seat->order->room,
                                    '',
                                    $seat->dealcode,
                                    $seat->phone,
                                    numbertomoney($seat->order->total-$seat->order->deposit),
                                    $seat->order->notice,
                                    '',
                                );
                                if($tour->isOutbound){
                                    $arr_row[] = $seat->ppno;
                                    $arr_row[] = $seat->ppexpired;
                                } else {
                                    $arr_row[] = $seat->cmnd;
                                }
                                $sheet->row($index+5, $arr_row);

                            } else {
                                if(($preseat->order_id!=$seat->order_id)){
                                    $countseat = Seat::where('order_id','=',$seat->order_id)->count();
                                    $sheet->mergeCells('F'.($index+5).':F'.($index+5+$countseat-1));
                                    $sheet->mergeCells('K'.($index+5).':K'.($index+5+$countseat-1));
                                    $sheet->cells('A'.($index+5).':J'.($index+5), function($cells) {
                                        //$cells->setBorder('solid', 'solid', 'solid', 'solid');
                                        $cells->setFont(array(
                                            'bold'       =>  true,
                                        ));
                                        //$cells->setBackground('#DDDDDD');


                                    });
                                    $arr_row  = array(
                                        $index+1,$seat->fullname,
                                        $seat->DOB,
                                        $this->isChild($seat->DOB)==true?'x':'',
                                        $transport->is_bed?$arr_convert_bed[$seat->number]:$seat->number,
                                        $seat->order->room,
                                        '',
                                        $seat->dealcode,
                                        $seat->phone,
                                        numbertomoney($seat->order->total-$seat->order->deposit),
                                        $seat->order->notice,
                                        '',
                                    );
                                    if($tour->isOutbound){
                                        $arr_row[] = $seat->ppno;
                                        $arr_row[] = $seat->ppexpired;
                                    } else {
                                        $arr_row[] = $seat->cmnd;
                                    }
                                    $sheet->row($index+5, $arr_row);
                                } else {
                                    $arr_row = array(
                                        $index+1,$seat->fullname,
                                        $seat->DOB,
                                        $this->isChild($seat->DOB)==true?'x':'',
                                        $transport->is_bed?$arr_convert_bed[$seat->number]:$seat->number,
                                        '',
                                        '',
                                        $seat->dealcode,
                                        $seat->phone,
                                        '',
                                        '',
                                        '',
                                    );
                                    if($tour->isOutbound){
                                        $arr_row[] = $seat->ppno;
                                        $arr_row[] = $seat->ppexpired;
                                    } else {
                                        $arr_row[] = $seat->cmnd;
                                    }
                                    $sheet->row($index+5,$arr_row );
                                }

                            }
                            $preseat = $seat;
                        }
                        $sheet->cell('A52', function($cell) use($seats) {
                            $cell->setValue('Tổng số chỗ : '.count($seats));
                        });
                        $sheet->cell('C52', function($cell) use($seats , $children) {
                            $cell->setValue('NL : '.(count($seats)-$children));
                        });
                        $sheet->cell('E52', function($cell) use($children) {
                            $cell->setValue('TE : '.$children);
                        });
                        $sheet->cell('F47', function($cell)  {
                            $cell->setBorder(array(
                                'borders' => array(
                                    'top'   => array(
                                        'style' => 'solid'
                                    ),
                                )
                            ));
                        });
                    });
                })->export('xlsx');
            }
            return redirect()->back();
    }
    public function printCustomerList(Request $request){
        $user = $this->auth->user();
        if($user->role->slug =='admin'||$user->role->slug =='staff') {
            $path = app_path();
            $path_str = $path.'/File/'.'formkh.xlsx';
            $customers = User::where('role_id',3)->select(array('users.*',
                DB::raw('(select count(*) from orders where orders.customer_id = users.id) as total_order') ,
                DB::raw('(select sum(adult) from orders where orders.customer_id = users.id) as total_person')
            ))->get();
            Excel::load($path_str, function($file) use ($customers ) {
                $file->sheet('Sheet1', function($sheet) use($customers){
                    foreach($customers as $index=>$customer)
                    {
                        $str = '';
                        $tours  = Tour::whereHas('startdates',function($q) use ($customer){
                            $q->whereHas('orders',function($qq) use($customer) {
                                $qq->where('id',$customer->id);
                            });
                        })->get();
                        foreach($tours as $tour){
                            $str .= $tour->title.';';
                        }
                        $arr_row =  array(
                            $index+1,
                            $customer->fullname,
                            $customer->phone,
                            $customer->email,
                            $customer->address,
                            $customer->point,
                            count($tours),
                            $str,
                            $customer->total_person
                        );
                        $sheet->row($index+2, $arr_row);

                    }
                });
            })->export('xlsx');
        }
        return redirect()->back();
    }
    public function doFinished ()
    {
        $orders = Order::whereStatus(2)->whereHas('startdate',function($q){
            $q->where('startdate','<',new \DateTime());
        })->get();


        foreach($orders as $od)
        {
            $od->status = 3;
            $od->save();
        }
        return redirect()->back()->with('finished','Hoàn tất các hóa đơn xác nhận thành công');
    }
    public function delOrderForm()
    {
        $user = Auth::user();
        return view('front.staff.delorder',compact('user'));
    }
    public function forceDelOrder()
    {
            $inputs = Input::all();
            $order_id = filter_var($inputs['order_id'],FILTER_SANITIZE_NUMBER_INT);
            $order = Order::find($order_id);
            if($order->status==0){
                $order->addings()->detach();
                $order->delete();
            } else {
                return redirect()->back()->with('error','Vui lòng hủy đơn hàng trước');
            }
            return redirect()->back()->with('ok','Xóa thành công');
    }
    private function isChild($dob){
        $year = date('Y');
        if($year-$dob<11){
            return true;
        }
        return false;
    }
    private function checkExistStartdate($cdate,$tour){
        $startdates = $tour->startdates ;
        foreach($startdates as $startdate){
            $kstartdate = Carbon::createFromFormat('Y-m-d H:i:s',$startdate->startdate) ;
            if($kstartdate->isSameDay($cdate)) {
                return false;
            }
        }
        return true;
    }
    public function showBookHotel(){
        $user = Auth::user();
        $hotelbooks = HotelBook::orderBy('seen')->latest()->paginate(20);
        $links = str_replace('/?', '?', $hotelbooks->render());
        return view('front.staff.hotel.index',compact('hotelbooks','links','user'));
    }
    public function showBookDetail($id){
        $user = Auth::user();
        $hotelbook = HotelBook::find($id);
        return view('front.staff.hotel.detail',compact('hotelbook','user'));
    }
    public function correctCustomerPoint($customer_id){
        $customer = User::find($customer_id);
        $plusorders = $customer->orders()->where('status','>',1)->get();
        $totalmoney = 0;
        foreach($plusorders as $od){
            $totalmoney += $od->total;
        }
        $totalpoint = round($totalmoney/1000);
        $subpoint = 0;
        $gifts  = $customer->gifts;
        foreach($gifts as $gf ){
            $subpoint += ($gf->point*$gf->pivot->amount);
        }
        $customer->point = $totalpoint-$subpoint;
        $customer->save();
    }
    public function correctPoint(){
        $customers = User::where('role_id','=',3)->get();
        foreach($customers as $cum){
            $this->correctCustomerPoint($cum->id);
        }
        return 'ok';
    }
    public function checkCustomer(Request $request){
        $user = Auth::user();
        if($request->isMethod('post')) {
            $namesearch = $request->get('string');
            $phone = $request->get('phone');
            $email = $request->get('email');
            $DOB = $request->get('DOB');
            $customers  = Seat::where('fullname','like','%'.$namesearch.'%');
            if($phone!='') $customers = $customers->where('phone',$phone);
            if($email!='') $customers = $customers->where('email',$email);
            if($DOB!='') $customers = $customers->where('DOB',$DOB);
            $customers = $customers->select('*', DB::raw('count(*) as total'))->groupBy('phone','DOB')->orderBy('phone')->get();
            //dd($customers);
            return view('front.staff.checkcustomer', compact('user','customers'));
        } else {
            return view('front.staff.checkcustomer', compact('user'));
        }
    }
    public function getAdding(Request $request){
        $data = array();
        $data['status'] = 0;
        if($request->isMethod('post')) {
            $tour_id = $request->get('tour_id');
            //$tour = Tour::find($request->get('tour_id'));
            $allstartdates = StartDate::where('tour_id','=',$tour_id)->orderBy('startdate', 'ASC')->get();
            $data['status'] = 1;
            $data['message'] = 'Lấy dữ liệu phụ thu thành công';
            $data['adding'] = array();
            foreach($allstartdates as $index=>$value){
                $dataa = array();
                $dataa['isForcedAddings_'.$value->id] = '{ "addings" : [' ;
                $addings = $value->addings()->whereHas('addingcate' , function($q) {
                    $q->where('isForced','=',1);
                })->get();
                foreach($addings as $index=>$adding) {
                    $dataa['isForcedAddings_'.$value->id] .= '{"title":"'.$adding->addingcate->title.'","price":"'.$adding->price.'"}'.($index+1<count($addings)?',':'');
                }
                $dataa['isForcedAddings_'.$value->id] .= '] , "childgtsix" : [';
                $adding = $value->addings()->whereHas('addingcate' , function($q) {
                    $q->whereId(2);
                })->first();
                if($adding!=null){
                    $dataa['isForcedAddings_'.$value->id] .= '{"title":"'.$adding->addingcate->title.'","price":"'.$adding->price.'"}'.($index+1<count($addings)?',':'');
                }
                $dataa['isForcedAddings_'.$value->id] .= '] , "childltsix" : [';
                $adding = $value->addings()->whereHas('addingcate' , function($q) {
                    $q->whereId(3);
                })->first();
                if($adding!=null){
                    $dataa['isForcedAddings_'.$value->id] .= '{"title":"'.$adding->addingcate->title.'","price":"'.$adding->price.'"}'.($index+1<count($addings)?',':'');
                }
                $dataa['isForcedAddings_'.$value->id] .= '] , "childltsix50" : [';
                $adding = $value->addings()->whereHas('addingcate' , function($q) {
                    $q->whereId(5);
                })->first();
                if($adding!=null){
                    $dataa['isForcedAddings_'.$value->id] .= '{"title":"'.$adding->addingcate->title.'","price":"'.$adding->price.'"}'.($index+1<count($addings)?',':'');
                }
                $dataa['isForcedAddings_'.$value->id] .= ']}';
                $data['adding'][] = $dataa;
            }
        } else {
            $data['message'] = 'Sai phương thức truy cập';
        }
        echo json_encode($data);
    }

    /*  Duy new 2019 */
    public function UpdateStartDate(Request $request){
        if($request->ajax()) {
            $user = Auth::user();
            $inputs = $request->all();
            $transport_type = Traffic::where('idtypeVehicle',$inputs['startdate_traffic'])->first();
            $totaltransport = ceil($inputs['startdate_seat']*1/ $transport_type->seat*1);
            if($inputs['startdate']!=''){
                $startdates = explode(',',$inputs['startdate']);
                $addings  = [];
                foreach ($inputs['adding_name'] as $index=>$adding){
                    $new_adding  = new \stdClass();
                    $new_adding->name = $inputs['adding_name'][$index];
                    $new_adding->price = $inputs['adding_price'][$index];
                    $new_adding->obj = $inputs['adding_obj'][$index];
                    $new_adding->required = $inputs['adding_required'][$index];
                    $new_adding->has_seat = $inputs['adding_hasSeat'][$index];
                    $addings[] = $new_adding;
                }
                foreach ($startdates as $index=>$sd) {
                    if(isset($inputs['id'])){
                        $new_sd = StartDate::find($inputs['id']);
                        if($user->role === 'admin'){ // only admin can edit startdate
                            $new_sd->startdate = Carbon::createFromFormat('d/m/Y',$sd)->toDateString();
                        }
                    } else {
                        $new_sd = new StartDate();
                        $new_sd->startdate = Carbon::createFromFormat('d/m/Y',$sd)->toDateString();
                        $new_sd->tour_id = $inputs['tour_id'];

                    }
                    $new_sd->traffic = $inputs['startdate_traffic'];// chỉ được phép gán khi tạo mới
                    $new_sd->seat = $inputs['startdate_seat'];
                    $new_sd->adult_price = $inputs['startdate_adult_price'];
                    $new_sd->baby_price = $inputs['startdate_baby_price'];
                    $new_sd->child_price = $inputs['startdate_child_price'];
                    $new_sd->addings = json_encode($addings);
                    $new_sd->save();
                    /////////////calculate transports
                    if(!isset($inputs['id'])){
                        for ($i = 0; $i < $totaltransport; $i++) {
                            $transport = new Transport();
                            $transport->startdate_id = $new_sd->id;
                            $transport->save();
                            $this->createSeat($transport->id , $transport_type->seat);
                        }
                    }
                }

            }
            return 'ok';
        }
        return 'fail';
    }
    public function createSeat($transportid , $transport_seats)
    {
        for($i=0;$i<$transport_seats;$i++)
        {
            $seat = new Seat();
            $seat->transport_id = $transportid;
            $seat->number = $i+1;
            $seat->save();
        }
    }
    public function DeleteStartDate(Request $request){
        if($request->ajax()) {
            $inputs = $request->all();
            $startdate = StartDate::find($inputs['id']);
            $user  = auth()->user();
            if(\auth()->user()->id === $startdate->tour->user_id ||  $user->role->slug === 'admin'){
                $startdate->delete();
            }
            return 'ok';
        }
        return 'fail';
    }
    public function GetStartDate(Request $request){
        if($request->ajax()) {
            $inputs = $request->all();
            $startdate = StartDate::find($inputs['id']);
//            dd($startdate->addings);
            return \GuzzleHttp\json_encode($startdate);
        }
        return 'fail';
    }
    private function CalcualateOrderTotal($order , $inputs){
        //dd($inputs);
        $rtn_obj = new \stdClass();

        /* Tính đơn hàng */
        $startdate = $order->startdate;
        $addings = collect(\GuzzleHttp\json_decode($startdate->addings));
        //dd($order->startdate);
        $total = 0;
        $total_adult_price = $order->adult * $startdate->adult_price;
        $total_child_price = $order->child * $startdate->child_price;
        $total_baby_price = $order->baby * $startdate->baby_price;
        $total = $total_adult_price+$total_child_price+$total_baby_price;
        $total_seat = $order->adult+$order->child;
        $adding_seat = 0;
        $tour_results = [];
        $order_addings = new \stdClass();
        $order_addings->adding_standard = '';
        $order_addings->adding_standard_price = 0;
        $order_addings->adding_required = [];
        $addingamount = 0;
        // phụ thu tiêu chuẩn
        $adding_standard = 0;
        $adding_standard_objs = $addings->filter(function ($value, $key)use ($inputs){
            return  $value->required === 'true' && ($value->obj*1) > 2 && $value->obj*1 === $inputs['standard']*1;
        });
        if($adding_standard_objs->count() > 0) {
            $adding_standard =$adding_standard_objs->first()->price *1;
            $adding_standard = $order->adult*$adding_standard;
        }
        $total += $adding_standard;
        // phụ thu bắt buộc
        $adding_required = 0;
        $adding_seat = 0;
        foreach ($addings as $index => $adding) {
            if($adding->required === 'true' && $adding->obj*1 <=2 ){
                $total_person = 0;
                if($adding->obj*1 === 0){
                    $total_person = $order->adult+$order->child+$order->baby ;
                }
                if($adding->obj*1 === 1){
                    $total_person = $order->child ;
                }
                if($adding->obj*1 === 2){
                    $total_person = $order->baby ;
                }
                $tmp_price = str_replace(',','',$adding->price);
                $total_price = ($tmp_price)* $total_person ;
                $adding_required += $total_price ;
                $addingamount += $total_price;
                /* adding standard */
                $adding->total_price = $total_price;
                $order_addings->adding_required[] = $adding ;
            }
        }
        // phụ thu không bắt buộc
        if(count($inputs['addingtype_norequired']) > 0 && $inputs['addingtype_norequired'][0] !== null ){
            foreach ($inputs['addingtype_norequired'] as $index => $adding_type ) {
                if($inputs['addingtype_norequired'][$index] === '1'){
                    $rtn_obj->adding_seat += $inputs['amount_norequired'][$index]*1 ;
                }
                var_dump($addingamount);
                $addingamount += $inputs['amount_norequired'][$index]*$inputs['addingprice_norequired'][$index];
                var_dump($addingamount);
                var_dump($inputs['amount_norequired'][$index]*$inputs['addingprice_norequired'][$index]);
                $adding = $addings->filter(function ($value, $key)use ($inputs , $index ){
                    return  $value->required === 'false' && $value->name === $inputs['addingtype_norequired'][$index];
                });
                $order_addings->adding_not_required[] = $adding ;
            }
        }

        $total += $addingamount;
        $rtn_obj->total = $total ;
        $rtn_obj->order_addings = $order_addings;
        $rtn_obj->adding_seat = $adding_seat ;
        return $rtn_obj;
    }
    public function GetMiscalculate(Request $request){
        if($request->ajax()) {
            $inputs = $request->all();
            //DB::enableQueryLog();
            $miscalculate_amounts = MiscalculateAmount::where('startdate_id',$inputs['startdate_id'])->get();
            $miscalculate_consult = MiscalculateConsult::where('startdate_id',$inputs['startdate_id'])->first();
            //dd(DB::getQueryLog());
            $obj = new \stdClass();
            $obj->amounts = $miscalculate_amounts;
            $obj->consult = $miscalculate_consult;
            return \GuzzleHttp\json_encode($obj);
        }
        return 'fail';
    }
    public function SaveMiscalculate(Request $request){
        if($request->ajax()) {
            $inputs = $request->all();
            $miscalculate_ids = $inputs['miscalculate_id'];
            if(count($miscalculate_ids)>0){
                DB::beginTransaction();
                $all_miscalculate = Miscalculate::all();
                $m_c = StartDate::where('id', $inputs['startdate_id'])->first()->miscalculate_consult()->first();//=> dở
                StartDate::where('id', $inputs['startdate_id'])->first()->miscalculate_amounts()->delete(); // => dở
                if(!$m_c) $m_c = new MiscalculateConsult();
                foreach ($miscalculate_ids as $index=>$miscalculate_id) {
                    $m_a = new MiscalculateAmount();
                    $in_mis_cal = $all_miscalculate->where('id',$miscalculate_id);
                    if(count($in_mis_cal) === 0 ){
                        return 'Không tìm thấy khoản đề xuất !';
                    }
                    $in_mis_cal = $in_mis_cal->first();
                    $m_a->title = $in_mis_cal->title;
                    $m_a->total_adult = filter_var($inputs['total_miscalculate_amount'][$index],FILTER_SANITIZE_NUMBER_INT);
                    $m_a->price = filter_var($inputs['miscalculate_price'][$index],FILTER_SANITIZE_NUMBER_INT);
                    $m_a->number = filter_var($inputs['total_miscalculate_number'][$index],FILTER_SANITIZE_NUMBER_INT);
                    $m_a->vat = filter_var($inputs['total_miscalculate_tax'][$index],FILTER_SANITIZE_NUMBER_INT);
                    $m_a->amount = $m_a->total_adult * $m_a->price ;
                    $m_a->startdate_id = filter_var($inputs['startdate_id'],FILTER_SANITIZE_NUMBER_INT);
                    $m_a->miscalculate_id = filter_var($miscalculate_id ,FILTER_SANITIZE_NUMBER_INT);
                    $m_a->save();
                }
                $m_c->total_adult = $inputs['total_adult'] ;
                $m_c->total_child = $inputs['total_child'] ;
                $m_c->total_customer = $inputs['total_customer'] ;
                $m_c->startdate_id = $inputs['startdate_id'] ;
                $m_c->total_amount = $inputs['total_amount'] ;
                $m_c->vat = $inputs['total_tax_amount'] ;
                $m_c->vat_real = $inputs['total_real_tax_amount'] ;
                $m_c->net_price = $inputs['sell_net_price'] ;
                $m_c->sell_price = $inputs['sell_price'] ;
                $m_c->interest = $inputs['interest'] ;
                $m_c->total_interest = $inputs['total_interest'] ;
                $m_c->interest_percent = $inputs['interest_percent'] ;
                $m_c->save();
                DB::commit();
                return 'ok';
            }
        }
        return 'fail';
    }
    public function SendMail(Request $request){
        $content = $request['content'];
        $page = $request['page']; // số trang
        $total = $request['total']; // số người gửi default 50

        $user = \auth()->user();
        $objDemo = new \stdClass();
        $objDemo->content = $content;
        $objDemo->sender = 'HAIDANGTRAVEL';
        $objDemo->receiver = 'quý khách';
        /// find customer list : hiện tại chỉ xử lý member time
        $staffid = '';
        if($user->role->slug !== 'admin'){
            $staffid = $user->id ;
        }
        $customers = User::where('role_id','=',3);
        if($staffid!='') {
            $staffid = filter_var($staffid , FILTER_SANITIZE_NUMBER_INT);
            $customers = $customers->whereHas('orders',function($q) use ($staffid) {
                $q->where('tourstaff_id','=',$staffid);
            });
        }
        $membertype = $request['membertype'];
        if($membertype!=''){
            $customers = $customers->where('member_card_type',$membertype);
        }
        $customers = $customers->paginate($total)->filter(function ($value, $key){
            return  filter_var( $value->email , FILTER_VALIDATE_EMAIL );
        });
        //dd($customers);
        Mail::to($customers)->send(new SendEmail($objDemo));
        //Mail::to('khanhduy2610@gmail.com')->send(new SendEmail($objDemo));
    }
}
