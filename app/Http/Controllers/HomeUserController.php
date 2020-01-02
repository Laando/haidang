<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Gift;
use App\Repositories\GiftRepository;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use App\Models\Adding;
use App\Models\Order;
use App\Models\Banner;
use App\Models\SubjectTour;
use App\Models\PromotionCode;
use App\Models\StartDate;
use App\Models\User;
use App\Models\Tour;
use Guzzle\Tests\Service\Mock\Command\Sub\Sub;
use Illuminate\Support\Facades\Input;
use Jenssegers\Agent\Agent;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\View;
use App\Models\SubjectBlog;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\SubmitCartRequest;
use App\Models\Config;
use App\Models\Car;
use App\Models\Blog;
use App\Models\DestinationPoint;
use App\Repositories\BlogRepository;
use Illuminate\Support\Facades\File;
class HomeUserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    private  $eventtimeconfig ;
    public function __construct(DestinationPoint $destinationpoint)
    {
        $this->middleware('auth',['except'=>array('viewCart','index','updateCart','submitCart','gift','CheckPoint','ConfirmGift')]);
        $this->user  = Auth::user();
        $cars = Car::all();
        $suggesttitle = Config::where('type', 'like', 'suggest-title')->first();
        $suggesttours = Tour::whereStatus(1)->where('isSuggest','=','1')->orderByRaw("RAND()")->get();
        $selectdestination = $destinationpoint->all()->pluck('title', 'id');
        $eventtimeconfig = Config::where('type','like','golden-hour')->first();
        $this->eventtimeconfig = $eventtimeconfig;
        $wishlist= Cookie::get('wishlist');
        $wishlist = $wishlist==null?'':$wishlist;
        if($wishlist==''){
            $wishlist_arr  = array();
        } else {
            $wishlist_arr  = explode(';',$wishlist);
        }
        $num_take = 14;
        $expiresAt = Carbon::now()->addMinutes(10);
        $destinationpoints = DestinationPoint::where('isOutbound',0)->orderBy('priority','ASC')->take($num_take)->get();
        $destinationpoints_out = DestinationPoint::where('isOutbound',1)->orderBy('priority','ASC')->take($num_take)->get();
        $currentstartdates = StartDate::where('startdate','>',new \DateTime());
        $currentstartdates = Cache::remember('currentstartdates',$expiresAt, function()use ($currentstartdates) {
            return $currentstartdates->orderBy('startdate','ASC')
                ->get()
                ->groupBy(function($date)
                {
                    return Carbon::parse($date->startdate)->format('m/d/Y');
                });
        });
        $tochucsukien = Cache::remember('tochucsukien',$expiresAt, function() {
            return SubjectBlog::whereSlug('To-Chuc-Su-Kien')->first();
        });
        $tochucsukienchilds  = Cache::remember('tochucsukienchilds',$expiresAt, function () use ($tochucsukien) {
            return $tochucsukien->getDescendants(2, array('id', 'parent_id', 'title' , 'slug'));
        });
        $subjecttours = Cache::remember('subjecttours',$expiresAt, function() {
            return SubjectTour::orderBy('priority','ASC')->get();
        });
        $homedemofooter  = Banner::where('type','like','footer-demo')->orderBy('priority','ASC')->take(4)->get();
        loadMenu();
        $agent = new Agent();
        View::share(compact( 'agent','cars','suggesttitle','suggesttours',
            'eventtimeconfig','selectdestination','wishlist_arr', 'destinationpoints','currentstartdates','homedemofooter',
            'tochucsukien','subjecttours',
            'tochucsukienchilds',
            'destinationpoints_out'));
    }
	public function index($page = '') {
        $user = auth()->user();
        if($user=== null){
            return redirect()->route('login');
        }
        $valide_page = array('home','address','order','wishlist');
        if(!in_array($page,$valide_page)) {
            $page = 'home';
        }
        $configtitle = Config::where('type', 'like', 'seotitle-homepage')->first();
        $seotitle = $configtitle->content;
        $configkeywword = Config::where('type', 'like', 'seokeyword-homepage')->first();
        $seokeyword = $configkeywword->content;
        $configdescription = Config::where('type', 'like', 'seodescription-homepage')->first();
        $seodescription = $configdescription->content;

        $subjectblogsroot  = SubjectBlog::roots()->orderBy('priority','ASC')->get();
        //$cart = Cart::content();
        $orders = Order::where('customer_id', '=', $user->id)->latest()->get();
        //dd($cart);
        //dd(Cart::count());
        //Cart::remove('7fea538bef45a581e3978b0834654477');
        $gifts = $user->gifts()->get();
        return View::make('front.user.userhome',compact(
        'page',
        'user',
        'subjectblogsroot',
        'page',
        'orders',
        'gifts',
        'seotitle',
        'seokeyword',
        'seodescription'
        ));
    }
    public function gift (Request $request) {
        $configtitle = Config::where('type', 'like', 'seotitle-homepage')->first();
        $seotitle = $configtitle->content;
        $configkeywword = Config::where('type', 'like', 'seokeyword-homepage')->first();
        $seokeyword = $configkeywword->content;
        $configdescription = Config::where('type', 'like', 'seodescription-homepage')->first();
        $seodescription = $configdescription->content;
        $user = auth()->user();
        $gifts = Gift::whereStatus(1)->get();
        return View::make('front.user.user_gift',compact(
            'gifts',
            'seotitle',
            'seokeyword',
            'seodescription'
        ));
    }
    public function CheckPoint (Request $request) {
        if($request->ajax()){
            $phone = $request['phone'];
            $point = User::where('phone',$phone)->first()->point;
        } else {
            abort(400,'Phương thức không hợp lệ');
        }
        return $point;
    }
    public function ConfirmGift (Request $request) {
        if($request->ajax()){
            DB::beginTransaction();
            $gift_id = $request['gift_id'];
            $gift = Gift::whereStatus(1)->whereId($gift_id)->first();
            $pivot_value = [
                'amount'=>$gift->point ,
                'status'=> 1 ,
                'created_at'=>Carbon::now()
            ];
            if($gift->expire != null){
                $pivot_value['expire'] = $gift->expire;
            }
            $user = auth()->user();
            $user->gifts()->attach($gift->id,$pivot_value);
            $user->point  -= $gift->point ;
            $user->save();
            DB::commit();
            return 'ok';
        } else {
            DB::rollback();
            abort(400,'Phương thức không hợp lệ');
        }
    }
    /*public function index($page = 1)
    {
        $configtitle = Config::where('type', 'like', 'seotitle-homepage')->first();
        $seotitle = $configtitle->content;
        $configkeywword = Config::where('type', 'like', 'seokeyword-homepage')->first();
        $seokeyword = $configkeywword->content;
        $configdescription = Config::where('type', 'like', 'seodescription-homepage')->first();
        $seodescription = $configdescription->content;
        if(Input::get('v')=='2') {
            $page = 2;
        }
        if(Input::get('v')=='3') {
            $page = 3;
        }
        if(Input::get('v')=='4') {
            $page = 4;
        }

        $user = $this->user ;
        $subjectblogsroot  = SubjectBlog::roots()->orderBy('priority','ASC')->get();
        $cart = Cart::content();
        if($user!=null) {
            $orders = Order::where('customer_id', '=', $user->id)->latest()->get();
        } else {
            $orders = new Order();
        }
        $user = Auth::user();
        if($user!=null){
            $eventposts  = Blog::where('author',$user->id)->whereHas('subjectblogs' , function($q) {
                $q->where('id','=',32);
            })->get();
        } else {
            $eventposts = null;
        }

        //dd($cart);
        //dd(Cart::count());
        //Cart::remove('7fea538bef45a581e3978b0834654477');
        return View::make('front.user.userhome',compact(
            'user',
            'subjectblogsroot',
            'page',
            'cart',
            'orders',
            'seotitle',
            'seokeyword',
            'seodescription',
            'eventposts'
        ));
    }*/
    public function listOrder()
    {
        return $this->index(3);
    }
    public function updateUser(Request $request)
    {
        $user = $this->user ;
        $messages = array(
            'alpha_num' => ':attribute chỉ gồm số và chữ ',
            'required' => ':attribute không được để trống',
            'max' => ':attribute tối đa :max ký tự',
            'min' => ':attribute tối thiểu :min ký tự',
            'unique' => ':attribute đã được sử dụng vui lòng chọn :attribute khác',
            'password.confirmed' => ':attribute xác nhận phải giống nhau',
        );
        $inputs = Input::all();
        $validator = Validator::make($inputs, [

            'password' => 'confirmed|max:20|min:8',
            'fullname' => 'required|max:255',
            'address' => 'max:255',
            'gender' =>array('Regex:/^(1)|(2)|(3)$/'),
            'dob' => 'required|max:255|date_format:d/m/Y',
        ],$messages);
        /*if($inputs['username']!=''&&$user->username==null){
            $validator->mergeRules("username", array('Regex:/^[a-zA-Z0-9]{0,20}$/'));
        }*/
        /*if($inputs['email']!=''&&$user->email==null){
            $validator->mergeRules("email", 'email|max:250|unique:users,email');
        }*/
        if ($validator->fails())
        {
            session()->flash('updateUser','Cập nhật User lỗi !');
            return redirect()->back()->withErrors($validator->errors());
        }
        //dd('oldpassword :'.$inputs['oldpassword'].'----hash oldpassword :'.bcrypt($inputs['oldpassword']).'-----database:'.$user->password);
        // user Hash::check to check 2 spot of sand\
        if(isset($inputs['oldpassword'])&&Hash::check($inputs['oldpassword'], $user->password))
        {
            $user->password = bcrypt($inputs['password']);
        }
       /* if($inputs['username']!=''&&$user->username==null) $user->username = $inputs['username'];
        if($inputs['email']!=''&&$user->email==null) $user->email = $inputs['email'];*/
        $user->fullname = strip_tags($inputs['fullname']);
        $user->gender = strip_tags($inputs['gender']);
        /*$user->address = strip_tags($inputs['address']);*/
        $user->dob = Carbon::createFromFormat('d/m/Y',$inputs['dob']);
        $getmail = isset($inputs['getmail'])?'1':'0';
        $user->getmail = $getmail;
        $user->save();
        return redirect('userhome/home')->with('ok','Sửa thông tin thành công');
;    }
    public function updateInfo(Request $request)
    {
        $user = $this->user ;
        $messages = array(
            'required' => ':attribute không được để trống',
            'max' => ':attribute tối đa :max ký tự',
        );
        $inputs = Input::all();
        $validator = Validator::make($inputs, [
            'address' => 'required|max:255',
            'can_weekend' =>array('Regex:/^(0)|(1)$/'),
            'address_type' =>array('Regex:/^(0)|(1)$/'),
        ],$messages);
        if ($validator->fails())
        {
            session()->flash('updateAddressUser','Cập nhật địa chỉ giao hàng User lỗi !');
            return redirect()->back()->withErrors($validator->errors());
        }
        $user->address = $inputs['address'];
        $user->can_weekend = $inputs['can_weekend'];
        $user->address_type = $inputs['address_type'];
        $user->save();
        return redirect('userhome/address')->with('ok','Sửa thông tin thành công');
        ;    }
    public function viewCart(Request $request , $isSubmitSuccess = false)
    {
        $user = $this->user ;
        if($request->method()!='GET'&&$isSubmitSuccess == false){
            $currentyear = date('Y');
            $minyear = $currentyear-10;
            $messages = array(
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max ký tự',
                'numeric'=> ':attribute phải là số',
                'between'=> ':attribute lớn hơn :min và nhỏ hơn :max'
            );
            $inputs = Input::all();
            $validator = Validator::make($inputs, [
                'starhotel' => 'numeric',
                'selectedstartdate' => 'required|numeric',
                'soluong' => 'required|numeric|between:1,100',
            ],$messages);
            if(isset($inputs['year'])) {
                $countyear = count($inputs['year']);
                $validator->mergeRules("sotreem", 'numeric|between:0,100|between:'.$countyear.','.$countyear);
            }
            $niceNames = array(
                'starhotel' => 'Chọn sao',
                'selectedstartdate' => 'Ngày khởi hành',
                'soluong' => 'Số người lớn',
                'sotreem' => 'Số trẻ em',
            );
            $year = array();

            if(isset($inputs['year'])) {
                //dd($inputs['year']);
                $cchosens = $inputs['cchosen'];
                foreach ($inputs['year'] as $key => $value) {
                    $validator->mergeRules("year.$key", "numeric|between:$minyear,$currentyear");
                    $validator->mergeRules("cchosen.$key", "numeric|between:0,1");
                    $niceNames["year.$key"]='Năm sinh';
                    $year[]=array('year'=>$value,'chosen'=>$cchosens[$key]);
                }
            }
            $validator->setAttributeNames($niceNames);
            if ($validator->fails())
            {
                return redirect()->back()->withInput($inputs)->withErrors($validator->errors());
            }
            $userid = isset($user)?$user->id:'';
            $startdateid = $inputs['selectedstartdate'];
            $adult = $inputs['soluong'];
            $child =$inputs['sotreem'];
            $totalcart = Cart::count();
            $startdate = StartDate::findOrFail($startdateid);
            $starprice = array();
            $starprice[] = $startdate->tour->star0;
            $starprice[] = $startdate->tour->star1;
            $starprice[] = $startdate->tour->star2;
            $starprice[] = $startdate->tour->star3;
            $starprice[] = $startdate->tour->star4;
            $starprice[] = $startdate->tour->star5;
            $starprice[] = $startdate->tour->rs2;
            $starprice[] = $startdate->tour->rs3;
            $starprice[] = $startdate->tour->rs4;
            $starprice[] = $startdate->tour->rs5;
            $array = array_where($starprice, function ($key, $value) use ($inputs) {
                return $value == $inputs['starhotel'];
            });

            if(count($array)==0) {
                $messages = new MessageBag;
                $messages->add('Lỗi giá', 'lỗi giá');
                return redirect()->back()->withInput($inputs)->withErrors($messages);
            }
            //Cart::add(array('id'=>$totalcart+1,'userid'=>$userid,'startdate'=>$startdateid,'adult'=>$adult,'child'=>$child ,$year));
            //$row = Cart::search(array('id' => $startdate->id));
            $row = Cart::search(function ($cartItem, $rowId) use ($startdate) {
                return $cartItem->id === $startdate->id;
            });
            if(!$row) {
                Cart::add(array('id' => $startdate->id,
                        'name' => $startdate->tour->title,
                        'qty' => $adult,
                        'price' => $inputs['starhotel'],
                        'options' => array('userid' => $userid,
                            'adult' => $adult,
                            'child' => $child,
                            'year' => $year,
                            'tour' => $startdate->tour
                        )
                    )
                );
            } else {
                session()->flash('carterror','Tour đã được đăng ký ! Vui lòng điều chỉnh !');
            }
            return redirect('usercart');
        }
        $step = 1;
        if($user == null) {
            $step =1 ;
        } else {
            $step = 2 ;
        }
        if($isSubmitSuccess) $step =3 ;
        $seotitle = 'Đơn hàng bước '.$step;
        $seokeyword = 'Đơn hàng bước '.$step;
        $seodescription = 'Đơn hàng bước '.$step;

        $cart = Cart::content();
        return View::make('front.user.usercart',compact(
            'user',
            'subjectblogsroot',
            'page',
            'cart',
            'orders',
            'seotitle',
            'seokeyword',
            'seodescription',
            'eventposts',
            'step'
        ));
    }
    public function updateCart(Request $request)
    {
        if($request->ajax()) {
            $user = $this->user;
            $currentyear = date('Y');
            $minyear = $currentyear - 10;
            $messages = array(
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max ký tự',
                'numeric' => ':attribute phải là số',
                'between' => ':attribute lớn hơn :min và nhỏ hơn :max'
            );
            $inputs = Input::all();
            $validator = Validator::make($inputs, [
                'starhotel' => 'numeric',
                'selectedstartdate' => 'required|numeric',
                'soluong' => 'numeric|between:1,100',
            ], $messages);
            if (isset($inputs['year'])) {
                $countyear = count($inputs['year']);
                $validator->mergeRules("sotreem", 'numeric|between:0,100|between:' . $countyear . ',' . $countyear);
            }
            $niceNames = array(
                'starhotel' => 'Chọn sao',
                'selectedstartdate' => 'Ngày khởi hành',
                'soluong' => 'Số người lớn',
                'sotreem' => 'Số trẻ em',
            );
            $year = array();

            if (isset($inputs['year'])) {
                //dd($inputs['year']);
                $cchosens = $inputs['cchosen'];
                foreach ($inputs['year'] as $key => $value) {
                    $validator->mergeRules("year.$key", "numeric|between:$minyear,$currentyear");
                    $validator->mergeRules("cchosen.$key", "numeric|between:0,1");
                    $niceNames["year.$key"] = 'Năm sinh';
                    $year[] = array('year' => $value, 'chosen' => $cchosens[$key]);
                }
            }
            $validator->setAttributeNames($niceNames);
            if ($validator->fails()) {
                return json_encode($validator->errors());
            }
            $userid = isset($user) ? $user->id : '';
            $startdateid = $inputs['selectedstartdate'];
            $adult = $inputs['soluong'];
            $child = $inputs['sotreem'];
            $totalcart = Cart::count();
            $startdate = StartDate::findOrFail($startdateid);
            $starprice = array();
            $starprice[] = $startdate->tour->star2;
            $starprice[] = $startdate->tour->star3;
            $starprice[] = $startdate->tour->star4;
            $starprice[] = $startdate->tour->star5;
            $array = array_where($starprice, function($key, $value) use ($inputs)
            {
                return $value==$inputs['starhotel'];
            });
            if(count($array)==0) {
                $messages = new MessageBag;
                $messages->add('Lỗi giá', 'lỗi giá');
                return json_encode($messages);
            }
            //Cart::add(array('id'=>$totalcart+1,'userid'=>$userid,'startdate'=>$startdateid,'adult'=>$adult,'child'=>$child ,$year));
            $rowid = $inputs['rid'];
            Cart::update($rowid, array('id' => $startdate->id,
                'name' => $startdate->tour->title,
                'qty' => $adult,
                'price' => $inputs['starhotel'],
                'options' => array('userid' => $userid,
                    'adult' => $adult,
                    'child' => $child,
                    'year' => $year,
                    'tour' => $startdate->tour
                )
                                    )
                        );
            return 'ok';
        } else {
            dd('not ajax');
        }
    }
    public function submitCart(SubmitCartRequest $request)
    {
        $inputs = Input::all();
        $user = $this->user;
        $address = $inputs['address'];
        if($user==null) {
            $user = new User();
            if ($inputs['username'] != '')
            {
                $user->username = $inputs['username'];
            }
            if ($inputs['email'] != '')
            {
                $user->email = $inputs['email'];
            }
            if ($inputs['fullname'] != '')
            {
                $user->fullname = $inputs['fullname'];
                $user->fullnameen = khongdau($user->fullname);
            }
            $user->phone = $inputs['phone'];
            if ($inputs['address'] != '')
            {
                $user->address = $inputs['address'];
            }
            $user->gender = $inputs['gender'];
            $user->password = Hash::make($inputs['password']);
            $user->role_id = 3;
            $user->getmail = 1;
            $user->status = 1;
            $user->lastlogin = Carbon::now();
            $user->save();
            Auth::login($user);
        } else {
            if($user->phone=='')
            {
                $user->phone = $inputs['phone'];
            }
            $user->address = $address;
            $user->save();
        }
        ////////////////save cart
        $this->saveCart($address);
        session()->flash('submitSuccess', 'Success');
        return $this->viewCart(Request::capture() , true);
    }
    function saveCart($address)
    {
        $eventtime =  Carbon::createFromFormat('Y-m-d H:i:s', $this->eventtimeconfig->content);
        $eventtimeend =  $eventtime->copy()->addHour(2);
        $now = Carbon::now();
        $inEvent = $now->between($eventtime, $eventtimeend);
        $user = Auth::user();
        $cart = Cart::content();
        $childgtsixprice = 0;
        $childltsixprice = 0;
        foreach($cart as $row)
        {
            $startdate = StartDate::find($row->id);
            $event = $startdate->tour->isGolden();
            $tickets = $startdate->countPromotionCode();
            $percent = $startdate->percent;
            // forced adding
            $forcedaddings = $startdate->addings()->whereHas('addingcate' , function($q) {
                $q->where('isForced','=',1);
            })->get();
            $totalforcedadding  = 0;
            foreach($forcedaddings as $adding)
            {
                $totalforcedadding += $adding->price;
            }
            $sellprice = ($row->price)+$totalforcedadding;
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
            $freechild = floor(($row->options->adult)/2);
            //create orders
            $order = new Order();
            $order->customer_id = $user->id;
            // customer book tour on web so tourstaff_id = staff_id
            $order->staff_id = $row->options->tour->user_id;
            $order->tourstaff_id = $row->options->tour->user_id;
            $order->startdate_id = $row->id;
            $order->status = 1;
            $order->adult = $row->options->adult;
            $order->isBook  = 0;
            $year = $row->options->year;
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
            $order->childlist = $childlist;
            $order->price = $row->price;
            $totaladult = $sellprice * ($row->options->adult);
            $totalchild = (count($childgt5addingid)*$childgtsixprice)+(count($childlt550addingid)*$childltsix50price)+(count($childlt5addingid)*$childltsixprice);
            $total = $totaladult+$totalchild;

            if($event) {
                if($row->options->adult<=$tickets) {
                    $discount = ($total * $percent / 100);
                } else {
                    $discount = (($tickets*$sellprice) * $percent / 100);
                }
                $total = $total - $discount;
                $order->discountgold = $discount;

            }
            $order->total = $total;
            $order->deposit = 0;
            $order->payment = 0;
            $order->addingamount = $totalchild;
            $order->addingseat = $count;
            $order->address = $address;
            $meraddings = array_merge($childgt5addingid,$childlt550addingid,$childlt5addingid);
            $order->online = true;
            $order->save();
            ///////////create promotioncode for order
            if($event) {
                $codes = $startdate->promotion_codes()->whereNull('order_id')->get();
                if ($row->options->adult <= $tickets) {
                    foreach ($codes as $key => $code) {
                        if ($key < $row->options->adult && $code->order_id == null) {
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
            ///////////create adding many to many
            if(count($meraddings)>0) {
                $order->addings()->attach($meraddings);
            }
        }
        Cart::destroy();
    }
    function createEventBlog(Request $request ,BlogRepository $blog_gestion ){
        $v = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);
        if ($v->fails())
        {
//            /dd($v->errors());
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $count = 1;
        $strimg = '';
        while(Input::hasFile('images-'.$count)){
            $file = Input::file('images-'.$count);
            $filename = khongdaurw($request['title']).'-hinh-'.$count.'.'.$file->getClientOriginalExtension();
            $strimg .= $filename . ';';
            //check file exist step
            $file->move('image',$filename);
            //waterMarkImage($filename);
            $count++;
        }
        $inputs  = Input::get();
        $inputs['subjecttours'] = array(32);
        $inputs['seokeyword'] = '';
        $inputs['seodescription'] = '';
        $inputs['seotitle'] = '';
        $blog_gestion->store_event($inputs,$strimg ,$this->user);
        return redirect()->back()->with('ok-event', 'Lưu bài dự thi thành công');
    }
    function editEventBlog(Request $request ,BlogRepository $blog_gestion){
        $inputs  = Input::get();
        $id = $inputs['id'];
        $strimages='';
        $blog = $blog_gestion->getBlogById($id);
        if(trim($request['title'])!=trim($blog->title)){
            $strimages = $blog->images;
            $arrimages = explode(';',trim($strimages,';'));
            if($strimages!='') {
                $strimages = '';
                $count = 1;
                foreach ($arrimages as $images) {
                    $ext = explode('.', $images);
                    if ($ext[1] != '') {
                        $newfile = khongdaurw($request['title']) . '-hinh-' . $count . '.' . $ext[1];
                        if (File::exists(public_path() . '/image/' . $images)) {
                            File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                        }
                        $strimages .= $newfile . ';';
                    }
                    $count++;
                }
            }
            $blog->images = $strimages;

            $blog->save();
        }
        //upload new images
        $strimg = $blog->images;
        $beginnumber = count(explode(';',$strimg));
        $countt = 1;
        while(Input::hasFile('images-'.$countt)){
            $count = 1;
            $file = Input::file('images-'.$countt);
            if($file->getClientOriginalExtension()!='') {
                $filename = khongdaurw($request['title']) . '-hinh-' . $beginnumber . '.' . $file->getClientOriginalExtension();
                $file->move('image', $filename);
                waterMarkImage($filename);
                if (strpos($strimg, $filename) === false) {
                    $strimg .= $filename . ';';
                }
                $beginnumber++;
                $countt++;
            }
        }
        if($strimg==''){$strimg = $strimages;}

        $inputs['subjecttours'] = array(32);
        $inputs['seokeyword'] = '';
        $inputs['seodescription'] = '';
        $inputs['seotitle'] = '';
        $blog = Blog::findOrFail($id);
        if($this->user->id == $blog->author&&$blog->publish==0){
            $blog_gestion->update_event($inputs,$id,$strimg ,$this->user);
            return redirect()->back()->with('ok-event', 'Lưu bài dự thi thành công');
        } else {
            return redirect()->back()->with('fail-event', 'Bạn không có quyện thay đổi bài viết này');
        }
    }
    public function sendConfirmEmail(Request $request){
        if($request->ajax()) {
            //// create confirm code
            $user = $this->user;
            $time_sent = Carbon::createFromFormat('Y-m-d H:i:s',$user->confirm_sent_at);
            $time_now = Carbon::now();
            $rs = $time_sent->diffInSeconds($time_now);
            if($rs <= 300){
                $data = [
                    'status' => '0',
                    'message' => 'Vui lòng đợi trong 5 phút !'
                ];
            } else {
                $user->confirm_sent_at = Carbon::now();
                $user->confirm_code = str_random(30);
                $user->save();
                //// send mail
                $data['confirm_code'] = $user->confirm_code;
                Mail::queue('emails.confirm_mail', $data, function ($message) use($user){
                    $message->subject('Mã xác nhận email từ haidangtravel.com');
                    $message->to($user->email);
                    $message->getSwiftMessage();
                });
                $data = [
                    'status' => '1'
                ];
            }
            echo json_encode($data);
        }
    }
    public function confirmEmail(Request $request){
        if($request->ajax()) {
            //// create confirm code
            $user = $this->user;
            $code = $request['code'];
            if($user->confirm_code  == $code){
                $user->confirmed_at = Carbon::now();
                $user->confirm = 1 ;
                $user->save();
                $data['confirm_code'] = $user->confirm_code;
                $data = [
                    'status' => '1'
                ];
            } else {
                $data = [
                    'status' => '0',
                    'message' => 'Mã xác nhận không đúng vui lòng nhập lại !'
                ];
            }
            echo json_encode($data);
        }
    }
    function loadMenu(){
        $expiresAt = \Carbon\Carbon::now()->addMinutes(10);
        $danhmuc_tourdoan = \Illuminate\Support\Facades\Cache::remember('danhmuc_tourdoan',$expiresAt, function() {
            return \App\Models\SubjectBlog::where('parent_id',1)->get();
        });
        $danhmuc_baiviet = \Illuminate\Support\Facades\Cache::remember('danhmuc_baiviet',$expiresAt, function() {
            return \App\Models\SubjectBlog::where('parent_id','!=',1)->get();
        });
        $diemden_trongnuoc = \Illuminate\Support\Facades\Cache::remember('diemden_trongnuoc',$expiresAt, function() {
            return \App\Models\DestinationPoint::where('isOutbound','!=',1)->where('isHomepage',1)->limit(10)->get();
        });
        $diemden_nuocngoai = \Illuminate\Support\Facades\Cache::remember('diemden_nuocngoai',$expiresAt, function() {
            return \App\Models\DestinationPoint::where('isOutbound',1)->where('isHomepage',1)->limit(10)->get();
        });
        $compact = array('danhmuc_tourdoan', 'danhmuc_baiviet' , 'diemden_nuocngoai' , 'diemden_trongnuoc');
        View::share(compact($compact));
    }
}
