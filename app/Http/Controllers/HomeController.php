<?php namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\PromotionCode;
use App\Models\StartDate;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\SightPoint;
use App\Repositories\SightPointRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Banner;
use App\Models\DestinationPoint;
use App\Models\Region;
use App\Models\SubjectBlog;
use App\Models\SubjectTour;
use App\Models\Tour;
use App\Repositories\BlogRepository;
use App\Repositories\HotelRepository;
use App\Models\Hotel;
use Auth;
use App\Models\Blog;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Mockery\Exception;
use Roumen\Feed\Facades\Feed;
use Illuminate\Support\Facades\URL;
use App\Models\Detail;
use App;
use App\Models\Car;
use App\Models\Review;
use App\Models\HotelBook;
use App\Http\Requests\GetTourResultRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\SubmitCartRequest;

class HomeController extends Controller
{

    public $links = array();

    /**
     * Display the home page.
     *
     * @return Response
     */
    public function __construct(Request $request, BlogRepository $blog_gestion)
    {
        $expiresAt = Carbon::now()->addMinutes(10);
        $this->blog_gestion = $blog_gestion;
        //$user = Auth::user();
        $tochucsukien = Cache::remember('tochucsukien', $expiresAt, function () {
            return SubjectBlog::whereSlug('To-Chuc-Su-Kien')->first();
        });
        $tochucsukienchilds = Cache::remember('tochucsukienchilds', $expiresAt, function () use ($tochucsukien) {
            if ($tochucsukien != null) {
                return $tochucsukien->getDescendants(2, array('id', 'parent_id', 'title', 'slug'));
            }
            return new Collection();
        });
        //$tochucsukienchilds->forget(0);
        //dd($tochucsukienchilds);
//        $regionmb = Cache::remember('regionmb',$expiresAt, function() {
//            return Tour::getTourByRegion(Region::where('title','like','Miền Bắc')->first())->count();
//        });
//        $regionmt = Cache::remember('regionmt',$expiresAt, function() {
//            return Tour::getTourByRegion(Region::where('title','like','Miền Trung')->first())->count();
//        });
//        $regionmn = Cache::remember('regionmn',$expiresAt, function() {
//            return Tour::getTourByRegion(Region::where('title','like','Miền Nam')->first())->count();
//        });

//        $countregions  = array();
//        $countregions['Miền Bắc'] = $regionmb;
//        $countregions['Miền Trung'] = $regionmt;
//        $countregions['Miền Nam'] = $regionmn;
        $subjectblogsroot = Cache::remember('subjectblogsroot', $expiresAt, function () {
            return SubjectBlog::roots()->orderBy('priority', 'ASC')->get();
        });
        $subhome = Cache::remember('subhome', $expiresAt, function () {
            return SubjectTour::where('homepage', '=', 1)->orderBy('priority', 'ASC')->first();
        });
        $subjecthome = Cache::remember('subjecthome', $expiresAt, function () {
            return SubjectTour::where('homepage', '=', 1)->orderBy('priority', 'ASC')->take(4)->skip(1)->get();
        });
        if ($subhome != null) {
            $listtournew = Cache::remember('listtournew', $expiresAt, function () use ($subhome) {
                return Tour::whereStatus(1)->whereHas('subjecttours', function ($q) use ($subhome) {
                    $q->where('id', '=', $subhome->id);//condition for tour has subject has homepage on;
                })->get()->pluck('id')->all();
            });
        } else {
            $listtournew = null;
        }
        $currentstartdates = StartDate::where('startdate', '>', new \DateTime());

        if (str_contains($request->path(), 'diem-den/') && !(str_contains($request->path(), 'tin-tuc'))) {
            $arrslug = explode('diem-den/', $request->path());
            $slug = $arrslug[1];
            //key of $tours is hometours
            $tours = Cache::remember('hometours' . $slug, $expiresAt, function () use ($slug) {
                return Tour::whereStatus(1)->whereHas('destinationpoints', function ($q) use ($slug) {
                    $q->where('slug', 'like', $slug);
                })->pluck('id')->all();
            });
            $currentstartdates = $currentstartdates->whereIn('tour_id', $tours);
        }
        $currentstartdates = Cache::remember('currentstartdates', $expiresAt, function () use ($currentstartdates) {
            return $currentstartdates->orderBy('startdate', 'ASC')
                ->get()
                ->groupBy(function ($date) {
                    return Carbon::parse($date->startdate)->format('m/d/Y');
                });
        });
        $configtitle = Cache::remember('configtitle' . $request->path(), $expiresAt, function () use ($request) {
            if ($request->is('tour-trong-nuoc')) {
                return Config::where('type', 'like', 'seotitle-domestic')->first();
            }
            if ($request->is('tin-tuc')) {
                return Config::where('type', 'like', 'seotitle-blog')->first();
            }
            return Config::where('type', 'like', 'seotitle-homepage')->first();
        });
        $seotitle = $configtitle->content;
        $configkeywword = Cache::remember('configkeywword' . $request->path(), $expiresAt, function () use ($request) {
            if ($request->is('tour-trong-nuoc')) {
                return Config::where('type', 'like', 'seokeyword-domestic')->first();
            }
            if ($request->is('tin-tuc')) {
                return Config::where('type', 'like', 'seokeyword-blog')->first();
            }
            return Config::where('type', 'like', 'seokeyword-homepage')->first();
        });
        $seokeyword = $configkeywword->content;
        $configdescription = Cache::remember('configdescription' . $request->path(), $expiresAt, function () use ($request) {
            if ($request->is('tour-trong-nuoc')) {
                return Config::where('type', 'like', 'seodescription-domestic')->first();
            }
            if ($request->is('tin-tuc')) {
                return Config::where('type', 'like', 'seodescription-blog')->first();
            }
            return Config::where('type', 'like', 'seodescription-homepage')->first();
        });
        $seodescription = $configdescription->content;
        $cars = Cache::remember('cars', $expiresAt, function () {
            return Car::all();
        });
        $suggesttitle = Cache::remember('suggesttitle', $expiresAt, function () {
            return Config::where('type', 'like', 'suggest-title')->first();
        });
        $suggesttours = Tour::whereStatus(1)->where('isSuggest', '=', '1')->orderByRaw("RAND()")->get();
        $experiencesb = Cache::remember('experiencesb', $expiresAt, function () {
            return SubjectBlog::where('parent_id', '=', 4)->get();
        });
        $relaxsb = Cache::remember('relaxsb', $expiresAt, function () {
            return SubjectBlog::where('parent_id', '=', 7)->latest()->take(6)->get();
        });
        $glblogs = Cache::remember('glblogs', $expiresAt, function () {
            return Blog::whereHas('subjectblogs', function ($q) {
                $q->where('id', '=', 22);
            })->latest()->take(9)->get();
        });
        $eventtimeconfig = Cache::remember('eventtimeconfig', $expiresAt, function () {
            return Config::where('type', 'like', 'golden-hour')->first();
        });
        $subjectblog_event = SubjectBlog::where('id', 32)->first();
        $eventtime = Carbon::createFromFormat('Y/m/d H:i:s', strip_tags($eventtimeconfig->content));
        $eventtimeend = $eventtime->copy()->addHour(2);
        $now = Carbon::now();
        $inEvent = $now->between($eventtime, $eventtimeend);
        $wishlist = Cookie::get('wishlist');
        $wishlist = $wishlist == null ? '' : $wishlist;
        if ($wishlist == '') {
            $wishlist_arr = array();
        } else {
            $wishlist_arr = explode(';', $wishlist);
        }
        loadMenu();
        $agent = new Agent();
        View::share(compact(
            'tours_trongnuoc',
            'eventtime', 'eventtimeend', 'now', 'inEvent', 'wishlist_arr',
            'subjecthome',
            'countregions',
            'subhome',
            'listtournew',
            'subjectblogsroot',
            'currentstartdates',
            'seotitle',
            'seokeyword',
            'seodescription',
            'cars',
            'suggesttitle',
            'suggesttours',
            'experiencesb',
            'relaxsb',
            'glblogs',
            'eventtimeconfig',
            'subjectblog_event',
            'tochucsukien',
            'tochucsukienchilds', 'all', 'isOutbound',
            'agent'
        ));
    }

    public function index()
    {
        $expiresAt = Carbon::now()->addMinutes(10);
        $template = 'front';
//        $homebol = true;

        $subjecttours = Cache::remember('subjecttours', $expiresAt, function () {
            return DB::table('subject_tours')->orderBy('priority', 'ASC')->where('isOutbound', '!=', 1)->get(['*', DB::raw('(select count(DISTINCT(id)) from tours join subjecttour_tour st on st.tour_id = tours.id and tours.status = 1 where st.subjecttour_id = subject_tours.id) as count_tour')]);
            //return SubjectTour::orderBy('priority','ASC')->get();
        });
        $tours_trongnuoc = Cache::remember('tours_trongnuoc', $expiresAt, function () {
            return Tour::whereStatus(1)->where('isOutbound', '!=', 1)->where('homepage', '=', 1)->orderBy('priority', 'ASC')->latest()->take(12)->get();
        });
        $tours_nuocngoai = Cache::remember('tours_nuocngoai', $expiresAt, function () {
            return Tour::whereStatus(1)->where('isOutbound', 1)->where('homepage', '=', 1)->orderBy('priority', 'ASC')->latest()->take(12)->get();
        });
//        $video_youtube = Cache::remember('video-youtube',$expiresAt, function() {
//            return Config::where('type', 'like', 'video-youtube')->first();
//        });
//        $homedestination_trongnuoc = Cache::remember('homedestination_trongnuoc',$expiresAt, function() {
//            return DB::table('destination_points')->orderBy('priority','ASC')->where('isOutbound','!=',1)->get(['*', DB::raw('(select count(DISTINCT(id)) from tours join destinationpoint_tour st on st.tour_id = tours.id and tours.status = 1 where st.destinationpoint_id = destination_points.id) as count_tour')]);
//            //return SubjectTour::orderBy('priority','ASC')->get();
//        });
//        $homedestination_nuocngoai = Cache::remember('homedestination_nuocngoai',$expiresAt, function() {
//            return DB::table('destination_points')->orderBy('priority','ASC')->where('isOutbound',1)->get(['*', DB::raw('(select count(DISTINCT(id)) from tours join destinationpoint_tour st on st.tour_id = tours.id and tours.status = 1 where st.destinationpoint_id = destination_points.id) as count_tour')]);
//            //return SubjectTour::orderBy('priority','ASC')->get();
//        });
        $homeslidebanners = Cache::remember('homeslidebanners', $expiresAt, function () {
            return Banner::where('type', 'like', 'homepage-slide')->orderBy('priority', 'ASC')->get();
        });
        $homepromobanners = Cache::remember('home-promo-banner', $expiresAt, function () {
            return Banner::where('type', 'like', 'home-promo-banner')->orderBy('priority', 'ASC')->get();
        });
//        $homesubjectbanner = Cache::remember('homesubjectbanner',$expiresAt, function()  {
//            return Banner::where('type','like','homepage-subject')->orderBy('priority','ASC')->first();
//        });
//        $homedestinationbanner = Cache::remember('homedestinationbanner',$expiresAt, function()  {
//            return Banner::where('type','like','homepage-destination')->orderBy('priority','ASC')->first();
//        });
//        $homegroupbanner = Cache::remember('homegroupbanner',$expiresAt, function()  {
//            return Banner::where('type','like','homepage-doan')->orderBy('priority','ASC')->first();
//        });
//        $hometopbanner = Cache::remember('hometopbanner',$expiresAt, function()  {
//            return Banner::where('type','like','homepage-top')->orderBy('priority','ASC')->first();
//        });
        $allhome_ids = [23, 11, 17, 20];// Tin tức , cẩm nang , video , hình ảnh
//        foreach ($allhome_ids as $index=>$id){
//            $check  = SubjectBlog::whereId($id)->get();
//            if($check->first() !== null){
//                $ids = SubjectBlog::where('id',$id)->first()->getDescendantsAndSelf()->pluck('id')->toArray();
//            }
//            $allhome_ids =   array_merge($allhome_ids,$ids);
//        }
        //Cache::flush();
        $home_blogs = Cache::remember('home_blogs', $expiresAt, function () use ($allhome_ids) {
            return Blog::whereHas('subjectblogs', function ($q) use ($allhome_ids) {
                $q->whereIn('id', $allhome_ids);
            })->latest()->take(8)->with('subjectblogs')->get();
        });
        //dd($home_blogs);
        Cache::forget('homebottombanners');
        $homebottombanners = Cache::remember('homebottombanners', $expiresAt, function () {
            return Banner::where('type', 'like', 'homepage-bottom-banner')->orderBy('priority', 'ASC')->take(3)->get();
        });
        $homedemofooter = Cache::remember('homedemofooter', $expiresAt, function () {
            return Banner::where('type', 'like', 'footer-demo')->orderBy('priority', 'ASC')->first();
        });

        //$ba = new Banner();
        //dd($ba);


//        $hometopdemo = Cache::remember('hometopdemo',$expiresAt, function() {
//            return Banner::where('type','like','home-top-demo')->orderBy('priority','ASC')->take(2)->get();
//        });
//        $homepromosmall = Cache::remember('homepromosmall',$expiresAt, function()  {
//            return Banner::where('type','like','home-middle-small-demo')->orderBy('priority','ASC')->take(2)->get();
//        });
//        $homepromobig = Cache::remember('homepromobig',$expiresAt, function() {
//            return Banner::where('type','like','home-middle-big-demo')->orderBy('priority','ASC')->take(2)->get();
//        });

        $destinationpoints = Cache::remember('destinationpoints', $expiresAt, function () {
            return DestinationPoint::where('isOutbound', 0)->orderBy('priority', 'ASC')->take(14)->get();
        });
        $destinationpoints_out = Cache::remember('destinationpoints_out', $expiresAt, function () {
            return DestinationPoint::where('isOutbound', 1)->orderBy('priority', 'ASC')->take(14)->get();
        });
        $toursweek = Cache::remember('toursweek', $expiresAt, function () {
            return Tour::whereStatus(1)->where('homepage', '=', 1)->whereHas('startdates', function ($q) {
                $now = Carbon::now()->toDateTimeString();
                $week = Carbon::now()->addDays(7)->toDateTimeString();
                $q->where('startdate', '>=', $now)->where('startdate', '<=', $week);
            })->orderBy('priority', 'ASC')->latest()->get();
        });
        $tourstoday = Cache::remember('tourstoday', $expiresAt, function () {
            return Tour::whereStatus(1)->where('homepage', '=', 1)->whereHas('startdates', function ($q) {
                $now = Carbon::createFromFormat('Y-m-d', Carbon::now()->toDateString());
                $tomorrow = Carbon::createFromFormat('Y-m-d', Carbon::now()->addDay()->toDateString());
                $q->where('startdate', '>=', $now)->where('startdate', '<=', $tomorrow);
            })->orderBy('adultprice', 'ASC')->latest()->get();
        });
        $tourssubject = array();
        /*$tourssubject = Cache::remember('tourssubject',$expiresAt, function()  {
            return SubjectTour::where('homepage','=',1)->orderBy('priority', 'ASC')->first()->tours()->whereStatus(1)->whereHas('startdates',function($q){
                $now = Carbon::now()->toDateTimeString();
                $q->where('startdate','>=',$now);
            } )->orderBy('priority','ASC')->latest()->take(12)->get();
        });*/
        //dd($tourssubject);
        $arr = array();
        foreach ($tourssubject as $tt) {
            $arr[] = $tt->id;
        }
        $tours = Cache::remember('tours_home', $expiresAt, function () use ($arr) {
            return Tour::whereStatus(1)->where('homepage', '=', 1)->whereNotIn('id', $arr)->orderBy('priority', 'ASC')->latest()->take(8)->get();
        });
        //$tours =  Tour::whereStatus(1)->orderBy('priority','ASC')->latest()->take(12)->get();

        $blogs_event = Cache::remember('blogs_event_home', $expiresAt, function () {
            return Blog::whereHas('subjectblogs', function ($q) {
                $q->where('id', '!=', 32)->where('id', 10);
            })->latest()->take(6)->get();
        });
        $blogs_customer = Cache::remember('blogs_customer_home', $expiresAt, function () {
            return Blog::whereHas('subjectblogs', function ($q) {
                $q->where('id', '!=', 32)->where('id', 22);
            })->latest()->take(6)->get();
        });
        $tours_mostsale = Cache::remember('tours_mostsale', $expiresAt, function () {
            return DB::table('tours')->where('status', 1)->orderBy('count_order', 'DESC')->limit(8)->get(['*', DB::raw('(select sum(adult) from orders where startdate_id in (select id from start_dates where tour_id = tours.id)) as count_order')]);
        });
        //DB::enableQueryLog();$rs = DB::table('regions')->where('isOutbound',1)->get(['*', DB::raw('(select count(*) from tours join destinationpoint_tour dt on dt.tour_id = tours.id and tours.status = 1 where dt.destinationpoint_id in (select id from destination_points where region_id = regions.id)) as count_tour')]);dd(DB::getQueryLog());
        $mn_outbound = Cache::remember('mn_outbound', $expiresAt, function () {
            return DB::table('regions')->where('isOutbound', 1)->get(['*', DB::raw('(select count(DISTINCT(id)) from tours join destinationpoint_tour dt on dt.tour_id = tours.id and tours.status = 1 where dt.destinationpoint_id in (select id from destination_points where region_id = regions.id)) as count_tour')]);
        });
        $mn_domestic = Cache::remember('mn_domestic', $expiresAt, function () {
            return DB::table('regions')->where('isOutbound', 0)->get(['*', DB::raw('(select count(DISTINCT(id)) from tours join destinationpoint_tour dt on dt.tour_id = tours.id and tours.status = 1 where dt.destinationpoint_id in (select id from destination_points where region_id = regions.id)) as count_tour')]);
        });
        return view($template . '.index', compact(
            'subjecttours',
            'tours_trongnuoc',
            'tours_nuocngoai',
            'video_youtube',
            'homedestination_trongnuoc',
            'homedestination_nuocngoai',
            'homeslidebanners',
            'homesubjectbanner',
            'homedestinationbanner',
            'homegroupbanner',
            'hometopbanner',
            'home_blogs',

            'destinationpoints',
            'destinationpoints_out',
            'tourssubject',
            'tours',
            'homebottombanners',
            'homebol',
            'blogs_event',
            'toursweek',
            'tourstoday',
            'hometopdemo',
            'homepromosmall',
            'homepromobig',
            'homedemofooter',
            'blogs_customer',
            'tours_mostsale',
            'mn_domestic',
            'mn_outbound',
            'homepromobanners'
        ));
    }

    /**
     * Change language.
     *
     * @param  Illuminate\Session\SessionManager $session
     * @return Response
     */
    public function language(ChangeLocaleCommand $changeLocaleCommand)
    {
        $this->dispatch($changeLocaleCommand);

        return redirect()->back();
    }

    /**
     * Show Tour by subject tour
     *
     * @param  String $slug
     * @return View
     */
    public function showTourByDestinationPoint($slug)
    {
        return $this->showTourBySubjectTour($slug, $isDestinationPoint = true);
    }

    public function showTourBySubjectTour($slug, $isDestinationPoint = false)
    {
        $expiresAt = Carbon::now()->addMinutes(10);
        $template = 'front.tourdest';
        $inputs = Input::all();
        if (is_int($slug)) {
            $isOutbound = $slug;
            //Cache::flush();
            switch ($slug) {
                case  0 : // tour trong nuoc
                    $cate_banner = Cache::remember('cate_banner_domestic', $expiresAt, function () {
                        return Banner::where('type', 'like', 'tour-domestic-banner')->orderBy('priority', 'ASC')->get();
                    });
                    break;
                case  1 : // tour nuoc ngoai
                    $cate_banner = Cache::remember('cate_banner_outbound', $expiresAt, function () {
                        return Banner::where('type', 'like', 'tour-outbound-banner')->orderBy('priority', 'ASC')->get();
                    });
                    break;
                case  2 :// tour doan
                    $cate_banner = Cache::remember('cate_banner_group', $expiresAt, function () {
                        return Banner::where('type', 'like', 'tour-group-banner')->orderBy('priority', 'ASC')->get();
                    });
                    break;
            }
            $tours = Tour::where('isOutbound', $isOutbound);
            if (isset($inputs['tour_dest'])) {
                $tour_dest = array($inputs['tour_dest']);
                $tours = $tours->whereHas('destinationpoints', function ($q) use ($tour_dest) {
                    $q->whereIn('id', $tour_dest);
                });
            }
            if (isset($inputs['category'])) {
                $tour_subj = array($inputs['category']);
                $tours = $tours->whereHas('subjecttours', function ($q) use ($tour_subj) {
                    $q->whereIn('id', $tour_subj);
                });
            }
            if (isset($inputs['search_by_date'])) {
                $search_by_date = $inputs['search_by_date'];
                $tours = $tours->whereHas('startdates', function ($q) use ($search_by_date) {
                    $q->where('startdate', 'like', $search_by_date . '%');
                });
            }
        } else {
            $cate_banner = Cache::remember('cate_banner_dp', $expiresAt, function () {
                return Banner::where('type', 'like', 'tour-dp-banner')->orderBy('priority', 'ASC')->get();
            });
            if ($isDestinationPoint) {
                $destinationpoint = DestinationPoint::where('slug', 'like', $slug)->first();
                if ($destinationpoint == null) return redirect('tour-trong-nuoc');
            } else {
                $destinationpoint = SubjectTour::where('slug', 'like', $slug)->first();
                if ($destinationpoint == null) return redirect('tour-trong-nuoc');
                $template = 'front.tourcate';
            }
            $isOutbound = $destinationpoint->isOutbound;
            $arrimg = explode(';', $destinationpoint->images);
            $tours = $destinationpoint->tours();
        }
        //DB::enableQueryLog();
        //$tours = $tours->whereStatus(1)->orderBy('priority','ASC')->latest()->take($num_take)->get();
        $tours = $tours->whereStatus(1)->orderBy('priority', 'ASC')->latest()->get();
        $tour_startdate = loadTourStartDate($tours->pluck('id')->toArray());
        //dd(DB::getQueryLog());
        $region_menus = Region::where('isOutbound', $isOutbound)->get();

        $destinationpoints = Cache::remember('destinationpoints', $expiresAt, function () {
            return DestinationPoint::where('isOutbound', 0)->orderBy('priority', 'ASC')->take(14)->get();
        });

        $vehicletype = Cache::remember('vehicletype', $expiresAt, function () {
            return DB::table('typevehicle')
                ->select('*')
                ->get();
        });
        $arr_return = ['counttours_1star',
            'counttours_2star',
            'counttours_3star',
            'counttours_4star',
            'counttours_5star',
            'isOutbound',
            'cate_banner',
            'destinationpoint',
            'region_menus',
            'tours', 'tour_startdate', 'inputs',
            'tour_startdate',
            'destinationpoints',
            'vehicletype'
        ];
        return view($template, compact($arr_return));
    }

    public function showDomesticTour($isOutbound = 0, $all = false)
    {
        $inputs = Input::all();
        if (isset($inputs['isOutbound'])) $isOutbound = intval($inputs['isOutbound']);
        return $this->showTourBySubjectTour($isOutbound);
    }

    public function showOutboundTour($isOutbound = 1)
    {
        return $this->showTourBySubjectTour($isOutbound);
    }

    public function showGroupTour($isOutbound = 2)
    {
        return $this->showTourBySubjectTour($isOutbound);
    }

    public function showTourDetail($slug)
    {
        $template = 'front.tour';
        $num_take = 4;
        $demo = session()->get('demo');
        if ($demo) {
            $template = 'demo.tour';
            $num_take = 14;
        }
//        if($this->checkSlug($slug))
//        {
//            return $this->showSeoLink($slug);
//        }
        $destinationpoints = DestinationPoint::where('isOutbound', 0)->orderBy('priority', 'ASC')->take($num_take)->get();
        $destinationpoints_out = DestinationPoint::where('isOutbound', 1)->orderBy('priority', 'ASC')->take($num_take)->get();
        try {
            $tour = Tour::where('slug', 'like', $slug)->firstOrFail();
            $tour->increment('view');
        } catch (ModelNotFoundException $e) {
            return redirect()->action('HomeController@index');
        }
        //many to many through;
        $listsubject = $tour->subjecttours()->get()->pluck('id')->all();
        $toursrelate = Tour::whereStatus(1)->whereHas('subjecttours', function ($q) use ($listsubject) {
            $q->whereIn('id', $listsubject);
        })->where('id', '!=', $tour->id)
            ->orderBy('priority', 'ASC')
            ->take(6)
            ->get();
        $viewed_tour = explode(';', session()->get('viewd_tour'));
        $toursviewed = Tour::whereStatus(1)->whereIn('id', $viewed_tour)->get();
        //dd($toursviewed);
        if (!in_array($tour->id, $viewed_tour)) {
            $viewed_tour[] = $tour->id;
            session()->put('viewd_tour', implode(';', $viewed_tour));
        }
        //$stringtours = Cookie::get('tourdetail');
        //dd($stringtours);
        //$stringtours .= $tour->id.';';
        //Cookie::queue('tourdetail',$tour->toJson() , '10080');
        $user = Auth::user();
        if ($user == null) {
            $str = Cookie::get('rate');
            $arrstr = explode(';', trim($str, ';'));
            $isRated = false;
            foreach ($arrstr as $st) {
                if ($st == $tour->slug) {
                    $isRated = true;
                    break;
                }
            }
        } else {
            $countrv = $user->whereHas('reviews', function ($q) use ($tour) {
                $q->where('tour_id', '=', $tour->id);
            })->count();
            $isRated = $countrv > 0 ? true : false;
        }
        $reviews = Review::where('tour_id', '=', $tour->id)->whereSpam(0)->whereNotNull('approved')->latest()->take(6)->get();
        $reviewstar = Review::where('tour_id', '=', $tour->id)->whereSpam(0)->whereNotNull('approved')->pluck('rating')->all();
        $star5 = 0;
        $star4 = 0;
        $star3 = 0;
        $star2 = 0;
        $star1 = 0;
        foreach ($reviewstar as $index => $value) {
            if ($value == 5) $star5++;
            if ($value == 4) $star4++;
            if ($value == 3) $star3++;
            if ($value == 2) $star2++;
            if ($value == 1) $star1++;
        }
        $countrv = count($reviewstar);
        $arrstar = array();
        $arrstar[] = $star1;
        $arrstar[] = $star2;
        $arrstar[] = $star3;
        $arrstar[] = $star4;
        $arrstar[] = $star5;
        $homepromosmall = Banner::where('type', 'like', 'home-middle-small-demo')->orderBy('priority', 'ASC')->take(2)->get();
        $homepromobig = Banner::where('type', 'like', 'home-middle-big-demo')->orderBy('priority', 'ASC')->take(2)->get();
        $homedemofooter = Banner::where('type', 'like', 'footer-demo')->orderBy('priority', 'ASC')->take(4)->get();
        //$blogsrelate = Blog::whereIn('destinationpoint_id', $tour->destinationpoints()->get()->pluck('id')->toArray())->orderByRaw("RAND()")->take(10)->get();
        return view($template, compact(
            'blogsrelate',
            'destinationpoints',
            'destinationpoints_out',
            'tourssubject',

            'tour',
            'toursrelate',
            'toursviewed',
            'isRated',
            'arrstar',
            'countrv',
            'reviews',
            'homepromosmall',
            'homepromobig',
            'homedemofooter'
        ));
    }

    public function showBlogHome($slug = '', $blogs = null)
    {
        $blog_cate = SubjectBlog::whereSlug($slug)->first();
        if($blog_cate !== null){
            return $this->showBlogTB($slug , $this->blog_gestion , Request::capture());
        }
        $blog = Blog::whereSlug($slug)->with('admin', 'subjectblogs')->wherePublish(1)->first();
        $alldestinationpoint = DestinationPoint::where('isHomepage', 1)->withCount('blogs')->orderBy('blogs_count', 'DESC')->get();
        $relateblogs = Blog::where('destinationpoint_id', $blog->destinationpoint_id)->where('id', '!=', $blog->id)->latest()->take(5)->get();
        $mostviewblogs = Blog::orderBy('view', 'desc')->where('id', '!=', $blog->id)->take(3)->get();
        $newestblogs = Blog::latest()->where('id', '!=', $blog->id)->take(3)->get();
        $blog->view++;
        $blog->save();
        return view('front.blog', compact(
            'blog',
            'newestblogs',
            'relateblogs',
            'subjectblog',
            'destinationpoints',
            'links',
            'mostviewblogs',
            'taggroup',
            //'allsubjectblog',
            'alldestinationpoint'
        ));
    }

    public function showBlogGuide(BlogRepository $blog_gestion, Request $request)
    {
        $request['category'] = 'cam-nang-du-lich';
        return $this->showBlogHomeAll($blog_gestion, $request);
    }

    public function showBlogTB($slug  ,BlogRepository $blog_gestion, Request $request)
    {
        $request['category'] = $slug;
        return $this->showBlogHomeAll($blog_gestion, $request);
    }

    public function showBlogHomeAll(BlogRepository $blog_gestion, Request $request)
    {

        $inputs = $request->all();
        if ($request->has('category')) {
            $subjectblog_blog = SubjectBlog::where('slug', 'like', '%' . $inputs['category'] . '%')->first();
        } else {
            $subjectblog_blog = SubjectBlog::where('slug', 'like', 'Tin-tuc')->first();
        }
        if ($request->has('destination')) {
            $destinationpoint_blog = DestinationPoint::where('slug', $inputs['destination'])->first();
        } else {
            $destinationpoint_blog = new \stdClass();
            $destinationpoint_blog->id = '';
            $destinationpoint_blog->slug = '';
        }
        if (!isset($inputs['query'])) {
            $inputs['query'] = '';
        }
        $destinationpoints_blog = DestinationPoint::orderBy('title', 'ASC')->get();
        $subjectblogs_blog = SubjectBlog::getNestedList('title', 'slug', $seperator = '--');
        //DB::enableQueryLog();
        $home_blogs = $blog_gestion->index(10,
            $destinationpoint_blog->id,
            $subjectblog_blog->id,
            $inputs['query']);
        $links = str_replace('/?', '?', $home_blogs->render());
        //dd(DB::getQueryLog());
        //dd($home_blogs);
        return view('front.homeblog', compact(
            'subjectblog_blog',
            'destinationpoints_blog',
            'subjectblogs_blog',
            'home_blogs',
            'links',
            'subjectblog',
            'destinationpoint_blog'
        ));
    }

    public function countLoadAjaxTour(Request $request)
    {
        if ($request->ajax()) {
            $tour_type = $request['isOutbound'];
            $tour_dest = $request['tour_dest'];
            $tour_star = $request['tour_star'];
            $tour_subj = $request['tour_subj'];
            $price_from = $request['price_from'];
            $price_to = $request['price_to'];
            $search_str = $request['search_str'];
            $search_by_date = $request['search_by_date'];
            $tours = Tour::whereStatus(1);
            if (count($tour_type) == 1) {
                $tours = $tours->where('isOutbound', $tour_type);
            }
            if (count($tour_dest) > 0) {
                $tours = $tours->whereHas('destinationpoints', function ($q) use ($tour_dest) {
                    $q->whereIn('id', $tour_dest);
                });
            }
            if (count($tour_star) > 0) {
                $tours = $tours->where(function ($query) use ($tour_star) {
                    foreach ($tour_star as $index => $star) {
                        $query = $query->orWhere('star' . $star, '!=', 0);
                        if ($star > 1) {
                            $query = $query->orWhere('rs' . $star, '!=', 0);
                        }
                    }
                });
            }
            if (count($tour_subj) > 0) {
                $tours = $tours->whereHas('subjecttours', function ($q) use ($tour_subj) {
                    $q->whereIn('id', $tour_subj);
                });
            }
            $tours = $tours->where('adultprice', '>=', $price_from)->where('adultprice', '<=', $price_to);
            ///////////// module search
            if ($search_str != '') {
                if (preg_match("/^(HD|hd)(\d){7}$/", $search_str)) {
                    $pattern = '/(hd)|(HD)/';
                    $search_str = preg_replace($pattern, '', $search_str);
                    $tour_id = intval(substr($search_str, 0, 5));
                    $tours = Tour::whereStatus(1)->where('id', $tour_id);
                } else {
                    $text = $search_str;
                    $textnon = khongdaurw($text);
                    $tours = $tours->where(function ($query) use ($text, $textnon) {
                        $query->whereHas('destinationpoints', function ($q) use ($text, $textnon) {
                            $q->where(function ($qq) use ($text, $textnon) {
                                $qq->orWhere('slug', 'like', '%' . $textnon . '%')->orWhere('title', 'like', '%' . $text . '%');
                            });
                        })
                            ->orWhere('title', 'like', '%' . $text . '%')
                            ->orWhere('slug', 'like', '%' . $textnon . '%')
                            ->orWhere('seokeyword', 'like', '%' . $text . '%')
                            ->orWhere('seokeyword', 'like', '%' . $textnon . '%');
                    });
                }
            }
            if ($search_by_date != '') {
                $tours = $tours->whereHas('startdates', function ($q) use ($search_by_date) {
                    $q->where('startdate', 'like', $search_by_date . '%');
                });
            }
            //////////////////
            //dd($tours->toSql());
            $tours = $tours->count();
            return response()->json($tours);
        } else {
            return 'You don\'t have right';
        }
    }

    public function getLoadAjaxTour(Request $request)
    {
        if ($request->ajax()) {
            $tour_type = $request['isOutbound'];
            $tour_dest = $request['tour_dest'];
            $tour_dest_out = $request['tour_dest_out'];
            $tour_star = $request['tour_star'];
            $tour_subj = $request['tour_subj'];
            $price_from = $request['price_from'];
            $price_to = $request['price_to'];
            $begin = $request['begin'];
            $search_str = $request['search_str'];
            $search_by_date = $request['search_by_date'];
            $begin = $request['begin'];
            $tours = Tour::whereStatus(1);
            if (count($tour_type) == 1) {
                $tours = $tours->where('isOutbound', $tour_type);
            }
            if (count($tour_dest) > 0) {
                $tours = $tours->whereHas('destinationpoints', function ($q) use ($tour_dest) {
                    $q->whereIn('id', $tour_dest);
                });
            }
            if (count($tour_dest_out) > 0) {
                $tours = $tours->whereHas('destinationpoints', function ($q) use ($tour_dest_out) {
                    $q->whereIn('id', $tour_dest_out);
                });
            }
            if (count($tour_star) > 0) {
                $tours = $tours->where(function ($query) use ($tour_star) {
                    foreach ($tour_star as $index => $star) {
                        $query = $query->orWhere('star' . $star, '!=', 0);
                        if ($star > 1) {
                            $query = $query->orWhere('rs' . $star, '!=', 0);
                        }
                    }
                });
            }
            if (count($tour_subj) > 0) {
                $tours = $tours->whereHas('subjecttours', function ($q) use ($tour_subj) {
                    $q->whereIn('id', $tour_subj);
                });
            }
            $tours = $tours->where('adultprice', '>=', $price_from)->where('adultprice', '<=', $price_to);
            ///////////// module search
            if ($search_str != '') {
                if (preg_match("/^(HD|hd)(\d){7}$/", $search_str)) {
                    $pattern = '/(hd)|(HD)/';
                    $search_str = preg_replace($pattern, '', $search_str);
                    $tour_id = intval(substr($search_str, 0, 5));
                    $tours = Tour::whereStatus(1)->where('id', $tour_id);
                } else {
                    $text = $search_str;
                    $textnon = khongdaurw($text);
                    $tours = $tours->where(function ($query) use ($text, $textnon) {
                        $query->whereHas('destinationpoints', function ($q) use ($text, $textnon) {
                            $q->where(function ($qq) use ($text, $textnon) {
                                $qq->orWhere('slug', 'like', '%' . $textnon . '%')->orWhere('title', 'like', '%' . $text . '%');
                            });
                        })
                            ->orWhere('title', 'like', '%' . $text . '%')
                            ->orWhere('slug', 'like', '%' . $textnon . '%')
                            ->orWhere('seokeyword', 'like', '%' . $text . '%')
                            ->orWhere('seokeyword', 'like', '%' . $textnon . '%');
                    });
                }
            }
            if ($search_by_date != '') {
                $tours = $tours->whereHas('startdates', function ($q) use ($search_by_date) {
                    $q->where('startdate', 'like', $search_by_date . '%');
                });
            }
            //////////////////
            //dd($tours->toSql());
            $tours = $tours->orderBy('priority', 'ASC')->latest()->take(4)->skip($begin)->get();
            //dd($tours);
            return view('front.touritem', compact('tours'));
        } else {
            return 'You don\'t have right';
        }
    }

    public function getLoadAjaxOrder(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            $name = $request['name'];
            $code = $request['code'];
            $page = $request['page'];
            $inputs = Input::all();
            $orders = App\Models\Order::where('status', '>=', 0);
            if ($user == null && $code != '') {
                $messages = array(
                    'code.regex' => 'Mã hóa đơn không đúng định dạng ! Chỉ chấp nhận kiểu HDxxxxx-xxxxxx (x là chữ số)',
                );
                $validator = Validator::make($inputs, [
                    'code' => array('Regex:/^(HD|hd)(\d){7}(-){0,1}(\d){6}$/')
                ], $messages);
                if ($validator->fails()) {
                    $data = array();
                    $data['status'] = 0;
                    $data['message'] = $validator->errors();
                    echo json_encode($data);
                    die;
                }
                $pattern = '/(hd)|(HD)/';
                $code = preg_replace($pattern, '', $code);
                $order_id = intval(substr($code, 0, 5));
                $startdate = substr($code, (count($code) - 1) - 6, 6);
                $startdate = '20' . substr($startdate, (count($startdate) - 1) - 2, 2) . '-' . substr($startdate, (count($startdate) - 1) - 4, 2) . '-' . substr($startdate, 0, 2);
                $orders = App\Models\Order::where('id', $order_id)->whereHas('startdate', function ($q) use ($startdate) {
                    $q->whereDate('startdate', '=', $startdate);
                })->latest()->paginate(10);

                $links = str_replace('/?', '?', $orders->render());
                $data['orders'] = view('demo.user.order_list', compact('orders'))->render();
                $data['links'] = $links;
                $data['status'] = 1;
                echo json_encode($data);
                die;
            } else {
                $orders = App\Models\Order::where('customer_id', '=', $user->id);
                if ($code != '') {
                    $messages = array(
                        'code.regex' => 'Mã hóa đơn không đúng định dạng ! Chỉ chấp nhận kiểu HDxxxxx-xxxxxx (x là chữ số)',
                    );
                    $validator = Validator::make($inputs, [
                        'code' => array('Regex:/^^(HD|hd)(\d){7}(-){0,1}(\d){6}$/')
                    ], $messages);
                    if ($validator->fails()) {
                        $data = array();
                        $data['status'] = 0;
                        $data['message'] = $validator->errors();
                        echo json_encode($data);
                        die;
                    }
                    $pattern = '/(hd)|(HD)/';
                    $code = preg_replace($pattern, '', $code);
                    $order_id = intval(substr($code, 0, 5));
                    $startdate = substr($code, (count($code) - 1) - 6, 6);
                    $startdate = '20' . substr($startdate, (count($startdate) - 1) - 2, 2) . '-' . substr($startdate, (count($startdate) - 1) - 4, 2) . '-' . substr($startdate, 0, 2);
                    $orders = $orders->whereHas('startdate', function ($q) use ($startdate) {
                        $q->whereDate('startdate', '=', $startdate);
                    });
                }
                if ($name != '') {
                    $orders = $orders->whereHas('startdate', function ($q) use ($name) {
                        $q->whereHas('tour', function ($qq) use ($name) {
                            $textnon = khongdaurw($name);
                            $qq->where(function ($qqq) use ($textnon, $name) {
                                $qqq->where('slug', 'like', '%' . $textnon . '%')->orWhere('title', 'like', '%' . $name . '%');
                            });
                        });
                    });
                }
                //dd($orders->toSql());
                $orders = $orders->latest()->paginate(10);
                $links = str_replace('/?', '?', $orders->render());
                $data['orders'] = view('demo.user.order_list', compact('orders'))->render();
                $data['links'] = $links;
                $data['status'] = 1;
                echo json_encode($data);
                die;
            }


        } else {
            echo 'No direct access !';
        }
    }

    public function loadAjaxDest(Request $request)
    {
        if ($request->ajax()) {
            $slug = $request['slug'];
            $type = $request['type'];
            $count = $request['count'];
            $skip = $count;
            switch ($type) {
                case 'sub' :
                    $destinationpoint = SubjectTour::where('slug', 'like', $slug)->first();
                    $tours = $destinationpoint->tours()->whereStatus(1)->orderBy('priority', 'ASC')->latest()->take(6)->skip($skip)->get();
                    break;
                case 'dest':
                    $destinationpoint = DestinationPoint::where('slug', 'like', $slug)->first();
                    $tours = $destinationpoint->tours()->whereStatus(1)->orderBy('priority', 'ASC')->latest()->take(6)->skip($skip)->get();
                    break;
                case 'mien':
                    $region = Region::where('slug', 'like', $slug)->first();
                    if ($region->count() > 0) {
                        $tours = Tour::whereStatus(1)->whereHas('destinationpoints', function ($q) use ($region) {
                            $q->where('region_id', '=', $region->id);
                        })->latest()->take(6)->skip($skip)->get();
                    } else {
                        $tours = null;
                    }
                    return view('partials.tourdestpartial', compact('tours'));
                    break;
                case 'date':
                    $date = $slug;
                    $inputs = array();
                    $inputs['date'] = $date;
                    $messages = array(
                        'date_format' => 'Ngày tháng không đúng định dạng'
                    );
                    $validator = Validator::make($inputs, [
                        'date' => 'date_format:d/m/Y',
                    ], $messages);
                    if ($validator->fails()) {
                        return 'Invalid date format';
                    }
                    $date = Carbon::createFromFormat('d/m/Y', $date);
                    $str = $date->toDateString();
                    $tours = Tour::whereStatus(1)->whereHas('startdates', function ($q) use ($str) {
                        $q->where('startdate', 'like', $str . '%');
                    })->latest()->take(6)->skip($skip)->get();
                    break;
                case 'text':
                    $text = $slug;
                    $textnon = khongdaurw($text);
                    $tours = Tour::whereStatus(1)
                        ->where(function ($query) use ($text, $textnon) {
                            $query->whereHas('destinationpoints', function ($q) use ($text, $textnon) {
                                $q->where(function ($qq) use ($text, $textnon) {
                                    $qq->orWhere('slug', 'like', '%' . $textnon . '%')
                                        ->orWhere('title', 'like', '%' . $text . '%');
                                });
                            })
                                ->orWhere('title', 'like', '%' . $text . '%')
                                ->orWhere('slug', 'like', '%' . $textnon . '%')
                                ->orWhere('seokeyword', 'like', '%' . $text . '%')
                                ->orWhere('seokeyword', 'like', '%' . $textnon . '%');
                        })
                        ->latest()
                        ->take(6)
                        ->skip($skip)
                        ->get();
                    break;
                default :
                    if (is_numeric($type)) {
                        $tours = Tour::whereStatus(1)->where('star' . $type, '!=', '0')->latest()->take(6)->skip($skip)->get();
                        return view('partials.tourdestpartial', compact('tours', 'type'));
                    } else {
                        return 'You don\'t have right 2';
                    }
                    break;
            }

            return view('partials.tourdestpartial', compact('tours'));
        } else {
            return 'You don\'t have right 1';
        }
    }

    public function getSearch(Request $request)
    {
        $expiresAt = Carbon::now()->addMinutes(10);
        $inputs = $request->all();
        $template = 'front.tourcate';
        $destinationpoints = Cache::remember('destinationpoints', $expiresAt, function () {
            return DestinationPoint::where('isOutbound', 0)->orderBy('priority', 'ASC')->take(14)->get();
        });
        $destinationpoints_out = Cache::remember('destinationpoints_out', $expiresAt, function () {
            return DestinationPoint::where('isOutbound', 1)->orderBy('priority', 'ASC')->take(14)->get();
        });
        $destinationpoints = $destinationpoints->merge($destinationpoints_out);
        $vehicletype = Cache::remember('vehicletype', $expiresAt, function () {
            return DB::table('typevehicle')
                ->select('*')
                ->get();
        });
        $tours = Tour::whereStatus(1)->where('isOutbound', '!=', 2);// không có tour đoàn
        if ($request->has('query_home')) {
            $tours = $tours->where('slug', 'like', '%' . str_slug($request['query_home']) . '%');
        }
        if ($request->has('destination')) {
            $destination_slug = $request->get('destination');
            $tours = $tours->whereHas('destinationpoints', function ($q) use ($destination_slug) {
                $q->where('slug', 'like', '%' . $destination_slug . '%');
            });
        }
        if ($request->has('standard')) {
            $standards = explode(',', $request['standard']);
            $tours = $tours->whereIn('starhotel', $standards);
        }
        if ($request->has('transport')) {
            $transports = explode(',', $request['transport']);
            $tours = $tours->whereHas('startdates', function ($q) use ($transports) {
                $q->where('startdate', '>', new \DateTime())->whereIn('idTypeVehicle', $transports);
            });
        }
        $tours = $tours->orderBy('priority', 'ASC')->latest()->get();
        $arr_return = ['counttours_1star',
            'counttours_2star',
            'counttours_3star',
            'counttours_4star',
            'counttours_5star',
            'isOutbound',
            'cate_banner',
            'destinationpoint',
            'region_menus',
            'tours', 'tour_startdate', 'inputs',
            'tour_startdate',
            'destinationpoints',
            'vehicletype'
        ];
        return view($template, compact($arr_return));
    }

    public function getSearchText($isOutbound = 0)
    {

        $search_cond = Input::get('search_cond');
        if (intval($search_cond > 2) || session()->has('searchcate')) {

            return $this->blogSearch();
        }
        $all = true;
        if ($search_cond == 1) {
            $isOutbound == 0;
            $all = false;
        }
        if ($search_cond == 2) {
            $isOutbound == 1;
            $all = false;
        }
        if ($search_cond == 3) {
            $isOutbound == 2;
            $all = false;
        }
        return $this->showDomesticTour($isOutbound, $all);
    }

    public function buildRss()
    {
        // create new feed
        $feed = Feed::make();
        // cache the feed for 60 minutes (second parameter is optional)
        //$feed->setCache(60, 'laravelFeedKey');

        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
            // creating rss feed with our most recent 20 posts
            $posts = Tour::whereStatus(1)->orderBy('created_at', 'desc')->take(10)->get();
            $blogs = Blog::orderBy('created_at', 'desc')->take(10)->get();
            // set your feed's title, description, link, pubdate and language
            $feed->title = 'Trang feed của HAIDANGTRAVEL';
            $feed->description = 'FEED RSS của HAIDANGTRAVEL - tour du lịch hay tin tức mới nhất';
            $feed->logo = 'http://haidangtravel.com.vn/assets/img/logo1-default.png';
            $feed->link = URL::to('rss');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = $posts[0]->created_at;
            $feed->lang = 'vi';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(100); // maximum length of description text
            foreach ($posts as $post) {
                // set item's title, author, url, pubdate, description and content
                $details = Detail::where('tour_id', '=', $post->id)->orderBy('day', 'asc')->get();
                $content = '';
                foreach ($details as $detail) {
                    $content .= $detail->content . '<hr/>';
                }
                $feed->add($post->title, 'HAIDANGTRAVEL', URL::to($post->slug), $post->updated_at, $post->description, $post->content);
            }
            foreach ($blogs as $blog) {
                $feed->add($blog->title, 'HAIDANGTRAVEL', asset('tin-tuc/' . $blog->slug . '.html'), $blog->updated_at, $blog->description, $blog->content);
            }
        }
        // first param is the feed format
        // optional: second param is cache duration (value of 0 turns off caching)
        // optional: you can set custom cache key with 3rd param as string
        $feed->setView('rss');
        return $feed->render('rss');
        // to return your feed as a string set second param to -1
        // $xml = $feed->render('atom', -1);
    }

    public function buildSitemap()
    {
        // create new sitemap object
        $sitemap = App::make("sitemap");
        // set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
        // by default cache is disabled
        //$sitemap->setCache('laravel.sitemap', 3600);
        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached()) {
            // add item to the sitemap (url, date, priority, freq)
            $dt = Carbon::now();
            $sitemap->add(URL::to('/'), $dt, '1.0', 'daily');
            $sitemap->add(URL::to('index.html'), $dt, '0.9', 'daily');
            // get all posts from db
            $posts = Tour::whereStatus(1)->orderBy('created_at', 'desc')->get();
            // add every post to the sitemap
            foreach ($posts as $post) {
                $sitemap->add(URL::to($post->slug), $post->updated_at, 0.8, 'daily');
            }
            $posts = SubjectTour::orderBy('created_at', 'desc')->get();
            foreach ($posts as $post) {
                $sitemap->add(asset('chu-de-tour/' . $post->slug), $post->updated_at, 0.8, 'daily');
            }
            $posts = DestinationPoint::orderBy('created_at', 'desc')->get();
            foreach ($posts as $post) {
                $sitemap->add(asset('diem-den/' . $post->slug), $post->updated_at, 0.8, 'daily');
                $sitemap->add(asset('tin-tuc/diem-den/' . $post->slug), $post->updated_at, 0.8, 'daily');
            }
            $posts = SightPoint::orderBy('created_at', 'desc')->get();
            foreach ($posts as $post) {
                $sitemap->add(asset('tin-tuc/diem-den/' . $post->slug . '.html'), $post->updated_at, 0.8, 'daily');
            }
            $posts = Blog::orderBy('created_at', 'desc')->get();
            foreach ($posts as $post) {
                $sitemap->add(asset('tin-tuc/' . $post->slug . '.html'), $post->updated_at, 0.8, 'daily');
            }
            $sitemap->add(asset('tour-du-lich-dao-binh-ba.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('Tour-Du-Lich-Binh-Ba-Binh-Tien-Binh-Hung-3N3D-171.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-ca-mau.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('CT-Dong-Gia-Tour-Du-Lich-Chau-Doc-Ha-Tien-2N2D-37.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-con-dao.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-da-lat.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-da-nang.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('CT-Dong-Gia-Tour-Du-Lich-Ba-Lua-Rung-Tram-Tra-Su-2N2D-99.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('CT-Dong-Gia-Tour-Du-Lich-Chau-Doc-Ha-Tien-2N2D-37.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-nha-trang.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-ninh-chu.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-phan-thiet.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-phu-quoc.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-phu-yen.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('tour-du-lich-vung-tau.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('bai-viet-248/Tour-tet-khuyen-mai.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('bang-gia-thue-xe.html'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('bang-gia'), Carbon::now(), 0.8, 'daily');
            $sitemap->add(asset('bai-viet-340/Du-lich-30-4-1-5-nam-2015.html'), Carbon::now(), 0.8, 'daily');
        }
        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        $sitemap->store('xml', 'sitemap');
        return $sitemap->render('xml');
    }

    public function ratingTour(Request $request)
    {
        $user = Auth::user();
        $inputs = Input::all();
        if ($user == null) {
            $messages = array(
                'stars-rated.max' => 'Sao tối đa là 5',
                'stars-rated.min' => 'Sao tối thiểu là 1',
                'max' => ':attribute tối đa :max ký tự',
                'min' => ':attribute tối thiểu :min ký tự',
                'required' => 'Không được để trống :attribute',
                'unique' => 'Email tồn tại vui lòng đăng nhập'
            );
            $niceNames = array(
                'ratingname' => 'Họ tên',
                'ratingemail' => 'Email',
                'stars-rated' => 'Số sao đánh giá ',
                'ratingcomment' => 'Ý kiến',
            );
            $validator = Validator::make($inputs, [
                'ratingname' => 'max:255|min:2|required',
                'ratingemail' => 'required|email|unique:users,email',
                'stars-rated' => 'required|max:5|min:1',
                'ratingcomment' => 'required|min:3|max:500',
            ], $messages);
            $validator->setAttributeNames($niceNames);
            if ($validator->fails()) {
                session()->flash('ratingError', 'Error');
                return redirect()->back()->withErrors($validator->errors());
            }
            $arrlinks = (explode('/', URL::previous()));
            $tour = Tour::whereStatus(1)->where('slug', 'like', $arrlinks[3])->first();
            if ($tour == null) return 'Error !';
            $str = Cookie::get('rate');
            Cookie::queue('rate', $str . $tour->slug . ';', '525600');
        } else {
            $messages = array(
                'stars-rated.max' => 'Sao tối đa là 5',
                'stars-rated.min' => 'Sao tối thiểu là 1',
            );
            $niceNames = array(
                'ratingcomment' => 'Ý kiến',
            );
            $validator = Validator::make($inputs, [
                'ratingcomment' => 'required|min:8|max:500',
            ], $messages);
            $validator->setAttributeNames($niceNames);
            if ($validator->fails()) {
                session()->flash('ratingError', 'Error');
                return redirect()->back()->withErrors($validator->errors());
            }
            $arrlinks = (explode('/', URL::previous()));
            $tour = Tour::whereStatus(1)->where('slug', 'like', $arrlinks[3])->first();
            if ($tour == null) return 'Error !';
        }
        //////////// create the review
        $review = new Review();
        $review->tour_id = $tour->id;
        if ($user != null) {
            $review->user_id = $user->id;
        } else {
            $review->name = $inputs['ratingname'];
            $review->email = $inputs['ratingemail'];
        }
        $review->rating = $inputs['stars-rated'];
        $review->comment = strip_tags($inputs['ratingcomment']);
        $review->approved = Carbon::now();
        $review->save();
        ////////////// calculate rating point
        $reviews = Review::where('tour_id', '=', $tour->id)->whereSpam(0)->whereNotNull('approved')->get();
        $countrv = Review::where('tour_id', '=', $tour->id)->whereSpam(0)->whereNotNull('approved')->count();
        $totalstar = 0;
        foreach ($reviews as $re) {
            $totalstar += $re->rating;
        }
        if ($countrv != 0) {
            $tour->rating_cache = $totalstar / $countrv;
        } else {
            $tour->rating_cache = 5;
        }
        $tour->rating_count = $countrv;
        $tour->save();
        return redirect()->back();
    }

    public function loadReview(Request $request)
    {
        if ($request->ajax()) {
            $slug = $request['slug'];
            $count = $request['count'];
            $skip = $count;
            $tour = Tour::whereStatus(1)->where('slug', 'like', $slug)->first();
            if ($tour != null) {
                if (is_numeric($count)) {
                    $reviews = Review::where('tour_id', '=', $tour->id)->whereSpam(0)->whereNotNull('approved')->latest()->take(6)->skip($skip)->get();
                    return view('partials.reviews', compact('reviews'));
                }
            }
        }
        return 'You don\'t have right 1';
    }

    public function viewHelp($slug)
    {
        $slug = strip_tags(stripslashes($slug));
        $config = Config::where('type', 'like', $slug)->first();
        return view('front.helper', compact(
            'config'
        ));
    }
//    public function showSeoLink($slug ){
//
//        //dd($slug);
//        if($slug=='tour-du-lich-dao-binh-ba.html'){
//            return $this->showTourByDestinationPoint('dao-binh-ba');
//        }
//        if($slug=='tour-du-lich-ca-mau.html'){
//            return $this->showTourByDestinationPoint('ca-mau');
//        }
//        if($slug=='tour-du-lich-con-dao.html'){
//            return $this->showTourByDestinationPoint('con-dao');
//        }
//        if($slug=='tour-du-lich-da-lat.html'){
//            return $this->showTourByDestinationPoint('da-lat');
//        }
//        if($slug=='tour-du-lich-da-nang.html'){
//            return $this->showTourByDestinationPoint('da-nang');
//        }
//        if($slug=='tour-du-lich-vung-tau.html'){
//            return $this->showTourByDestinationPoint('vung-tau');
//        }
//        if($slug=='tour-du-lich-nha-trang.html'){
//            return $this->showTourByDestinationPoint('nha-trang');
//        }
//        if($slug=='tour-du-lich-ninh-chu.html'){
//            return $this->showTourByDestinationPoint('ninh-chu');
//        }
//        if($slug=='tour-du-lich-phan-thiet.html'){
//            return $this->showTourByDestinationPoint('phan-thiet');
//        }
//        if($slug=='tour-du-lich-phu-quoc.html'){
//            return $this->showTourByDestinationPoint('phu-quoc');
//        }
//        if($slug=='tour-du-lich-phu-yen.html'){
//            return $this->showTourByDestinationPoint('phu-yen');
//        }
//        if($slug=='Tour-Du-Lich-Binh-Ba-Binh-Tien-Binh-Hung-3N3D-171.html'){
//            return $this->showTourDetail('Tour-du-lich-dao-Binh-Ba-dao-Binh-Hung-bien-Binh-Tien-3N3D');
//        }
//        if($slug=='CT-Dong-Gia-Tour-Du-Lich-Chau-Doc-Ha-Tien-2N2D-37.html'){
//            return $this->showTourDetail('Tour-du-lich-Ha-Tien-Chau-Doc-2N2D');
//        }
//        if($slug=='CT-Dong-Gia-Tour-Du-Lich-Ba-Lua-Rung-Tram-Tra-Su-2N2D-99.html'){
//            //dd($slug.'check');
//            return $this->showTourDetail('Tour-du-lich-Dao-Ba-Lua-2N2D');
//        }
//        if($slug=='Tour-tet-khuyen-mai.html'){
//            //die('cjec2');
//            return $this->showBlogHome('Chuong-trinh-khuyen-mai-tour-du-lich-tet-2016.html');
//        }
//        if($slug=='Du-lich-30-4-1-5-nam-2015.html'){
//            return $this->showBlogHome('Du-lich-30-4-1-5-nam-2016.html' );
//        }
//        if($slug=='bang-gia-thue-xe.html'){
//            return $this->showCarHome();
//        }
//
//    }
//    public function checkSlug($slug)
//    {
//        //die($slug);
//        $this->links[] = 'tour-du-lich-dao-binh-ba.html';
//        $this->links[] = 'Tour-Du-Lich-Binh-Ba-Binh-Tien-Binh-Hung-3N3D-171.html';
//        $this->links[] = 'tour-du-lich-ca-mau.html';
//        $this->links[] = 'CT-Dong-Gia-Tour-Du-Lich-Chau-Doc-Ha-Tien-2N2D-37.html';
//        $this->links[] = 'tour-du-lich-con-dao.html';
//        $this->links[] = 'tour-du-lich-da-lat.html';
//        $this->links[] = 'tour-du-lich-da-nang.html';
//        $this->links[] = 'CT-Dong-Gia-Tour-Du-Lich-Ba-Lua-Rung-Tram-Tra-Su-2N2D-99.html';
//        $this->links[] = 'CT-Dong-Gia-Tour-Du-Lich-Chau-Doc-Ha-Tien-2N2D-37.html';
//        $this->links[] = 'tour-du-lich-nha-trang.html';
//        $this->links[] = 'tour-du-lich-ninh-chu.html';
//        $this->links[] = 'tour-du-lich-phan-thiet.html';
//        $this->links[] = 'tour-du-lich-phu-quoc.html';
//        $this->links[] = 'tour-du-lich-phu-yen.html';
//        $this->links[] = 'tour-du-lich-vung-tau.html';
//        $this->links[] = 'Tour-tet-khuyen-mai.html';
//        $this->links[] = 'bang-gia-thue-xe.html';
//        $this->links[] = 'Du-lich-30-4-1-5-nam-2015.html';
//        foreach($this->links as $lks){
//            if($slug==$lks)
//            {
//                return true;
//            }
//        }
//        return false;
//    }
    public function showPriceSheet($type_price = 1)
    {
        $template = 'front.pricesheet';
        $demo = session()->get('demo');
        $num_take = 4;
        $take_subject = 6;
        if ($demo) {
            $num_take = 14;
            $take_subject = 12;
            $template = 'demo.pricesheet1';
        }
        $destinationpoints = DestinationPoint::where('isOutbound', 0)->orderBy('priority', 'ASC')->get();
        $destinationpoints_out = DestinationPoint::where('isOutbound', 1)->orderBy('priority', 'ASC')->get();
        $subjecttours = SubjectTour::where('isOutbound', 0)->orderBy('priority', 'ASC')->get();
        $subjecttours_out = SubjectTour::where('isOutbound', 1)->orderBy('priority', 'ASC')->get();
        $groupprice = '';
        switch ($type_price) {
            case 1 :
                $tours = Tour::whereStatus(1)->where('isOutbound', 0)->orderBy('priority', 'ASC')->get();
                break;
            case 2 :
                $tours = Tour::whereStatus(1)->where('isOutbound', 1)->orderBy('priority', 'ASC')->get();
                break;
            case 3 :
                $groupprice = Config::where('type', 'like', 'bang-gia-doan')->first();
                break;
            case 4 :
                $tours = Tour::whereStatus(1)->whereHas('subjecttours', function ($q) {
                    $q->where('id', 74);
                })->orderBy('priority', 'ASC')->get();
                break;
        }

        return view($template, compact(
            'destinationpoints',
            'destinationpoints_out',
            'subjecttours',
            'subjecttours_out',
            'tours',
            'type_price',
            'groupprice',
            'tourtopbanners'
        ));
    }

    public function showTourdonggia()
    {
        return view('front.tourdonggia');
    }

    public function getEmailForm()
    {
        $token = csrf_token();
        return view('auth.password', compact('token'));
    }

    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.reset')->with('token', $token);
    }

    public function noregister()
    {
        session()->flash('noregister', 'true');
        return redirect()->action('HomeUserController@index', ['v' => 2]);
    }

    private function renderPage($blogs, $n, $page)
    {
        $counto = count($blogs);
        $totalpage = round($counto / $n);
        $url = URL::current();
        $arrurl = explode('?', $url);
        $url = $arrurl[0];
        return view('front.blog.page', compact('totalpage', 'page', 'url'));
    }

    public function showHotelHome()
    {
        $homehotelcontent = Config::where('type', 'like', 'hotel-home-content')->first();
        $totalhoteldescription = DestinationPoint::has('hotels', '>', 0)->count();
        $hoteldestinationpoints = DestinationPoint::has('hotels', '>', 0)->orderBy('priority')->latest()->take(6)->get();
        return view('front.hotel.home', compact('hoteldestinationpoints', 'homehotelcontent', 'totalhoteldescription'));
    }

    public function showHotelByDestinationPoint($slug)
    {
        $hoteldestinationpoint = DestinationPoint::where('slug', 'like', $slug)->first();
        $homehotelcontent = Config::where('type', 'like', 'hotel-home-content')->first();
        $totalhoteldescription = $hoteldestinationpoint->hotels()->count();
        $hotels = $hoteldestinationpoint->hotels()->orderBy('homepage', 'DESC')->latest()->take(6)->get();
        return view('front.hotel.list', compact('hotels', 'homehotelcontent', 'totalhoteldescription', 'hoteldestinationpoint'));
    }

    public function loadAjaxHotelDest(Request $request)
    {
        if ($request->ajax()) {
            $slug = $request['slug'];
            $type = $request['type'];
            $count = $request['total'];
            $text = $request['text'];
            $star = $request['star'];
            $skip = $count;
            switch ($type) {
                case 'dest':
                    $hoteldestinationpoints = DestinationPoint::has('hotels', '>', 0)->orderBy('priority')->latest()->take(6)->skip($skip)->get();
                    return view('front.hotel.partials.destination', compact('hoteldestinationpoints'));
                    break;
                case 'desthotel':
                    $hoteldestinationpoint = DestinationPoint::where('slug', 'like', $slug)->first();
                    $hotels = $hoteldestinationpoint->hotels()->orderBy('homepage', 'DESC')->latest()->take(6)->skip($skip)->get();
                    return view('front.hotel.partials.destination', compact('hotels'));
                    break;
                case 'searchhotel':

                    break;
                default :

                    break;
            }

        } else {
            return 'You don\'t have right 1';
        }
    }

    public function showHolidayPage(Request $request)
    {
        $uri = $request->path();
        $return_view = '';
        if (str_contains($uri, 'tour-noel')) {
            $return_view = 'front.tournoel';
            $tours = Tour::whereStatus(1)->whereHas('subjecttours', function ($q) {
                $q->where('id', '=', 64);
            })->latest()->get();
        }
        if (str_contains($uri, 'tour-tet-duong-lich')) {
            $return_view = 'front.tourtetduonglich';
            $tours = Tour::whereStatus(1)->whereHas('subjecttours', function ($q) {
                $q->where('id', '=', 65);
            })->latest()->get();
        }
        if (str_contains($uri, 'tour-tet-am-lich')) {
            $return_view = 'front.tourtetamlich';
            $tours = Tour::whereStatus(1)->whereHas('subjecttours', function ($q) {
                $q->where('id', '=', 63);
            })->latest()->get();
        }
        $diemden_filter = array();
        foreach ($tours as $tour) {
            $des = $tour->destinationpoints;
            foreach ($des as $de) {
                if (!isset($diemden_filter[$de->id])) {
                    $diemden_filter[$de->id] = $de->title;
                }
            }
        }
        return view($return_view, compact('tours', 'diemden_filter'));
    }

    public function showIslandTour()
    {
        $tourisland = Tour::whereHas('subjecttours', function ($q) {
            $q->where('id', '=', 69);
        })->latest()->get();
        $blogisland = Blog::whereHas('subjectblogs', function ($q) {
            $q->where('id', '=', 31);
        })->latest()->take(3)->get();
        return view('front.island', compact('tourisland', 'blogisland'));
    }

    public function tourGioVang()
    {
        $homebottombanners = Banner::where('type', 'like', 'homepage-bottom-banner')->orderBy('priority', 'ASC')->get();
        //$orders  = App\Models\Order::where('discountgold','!=',0)->where('status','>',0)->whereDate('created_at', '=', Carbon::today()->toDateString())->latest()->get();
        $orders = App\Models\Order::where('discountgold', '!=', 0)->where('status', '>', 0)->latest()->get();
        $subhome = new \stdClass();
        $subhome->title = '';
        $tourssubject = Tour::whereStatus(1)->whereHas('startdates', function ($q) {
            $q->where('isEvent', '=', 1);
        })->latest()->get();
        // tour tour has startdate in gold event
        $tours = Tour::whereStatus(1)->whereHas('startdates',function($q){
            $q->where('startdate','>', Carbon::now());
            $q->where('isEvent',1);
        })->with(['startdates'=> function($sd){ //=> still in query builder
            $sd->where('startdate','>', Carbon::now());
            $sd->where('isEvent',1);
            $sd->with(['promotion_codes'=>function($pc){
                $pc->whereNull('order_id');
            }]);
        }])->get();
        return view('front.tourgiovang', compact(
            'tours',
            'orders',
            'tourssubject',
            'subhome',
            'homebottombanners'
        ));
    }

    public function indexEventPost()
    {
        $blogs = Blog::whereHas('subjectblogs', function ($q) {
            $q->where('id', '=', 32);
        })->where('publish', 1)->orderBy('like', 'desc')->take(12)->get();
        return View::make('front.eventpost.index', compact('blogs'));
    }

    public function listEventPost(Request $request)
    {
        //DB::enableQueryLog();
        $n = 4;
        $blogs = Blog::whereHas('subjectblogs', function ($q) {
            $q->where('id', '=', 32);
        })->where('publish', 1);
        if ($request->ajax()) {
            $input = Input::all();
            $type = $input['type'];
            $string = $input['string'];
            if ($string != '') {
                $text = $string;
                $textnon = khongdaurw($string);
                $blogs = $blogs->where(function ($query) use ($text, $textnon) {
                    $query->whereHas('destinationpoint', function ($q) use ($text, $textnon) {
                        $q->where(function ($qq) use ($text, $textnon) {
                            $qq->orWhere('slug', 'like', '%' . $textnon . '%')
                                ->orWhere('title', 'like', '%' . $text . '%');
                        });
                    })
                        ->orWhere('title', 'like', '%' . $text . '%')
                        ->orWhere('slug', 'like', '%' . $textnon . '%');
                });
            }
            if ($type == 'moi-nhat') {
                $blogs = $blogs->latest();
            } else {
                $blogs = $blogs->orderBy('like', 'desc');
            }
        }
        $blogs = $blogs->paginate($n);
        //dd(DB::getQueryLog());
        $links = str_replace('/?', '?', $blogs->render());
        if ($request->ajax()) {
            return response()->json([
                'view' => view('front.eventpost.table', compact('blogs', 'links'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }
        return View::make('front.eventpost.list', compact('blogs', 'links'));
    }

    public function ruleEventPost()
    {
        return View::make('front.eventpost.rule');
    }

    public function detailEventPost($slug)
    {
        $arr_tmp = explode(".html", $slug);
        $slug = $arr_tmp[0];
        $blog = Blog::where('slug', $slug)->where('publish', 1)->first();
        /////////////////////
        $fql = "SELECT url, normalized_url, share_count, like_count, comment_count, ";
        $fql .= "total_count, commentsbox_count, comments_fbid, click_count FROM ";
        $fql .= "link_stat WHERE url = '" . asset('eventblog/' . $blog->slug . '.html') . "'";
        $apifql = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);
        $json = file_get_contents($apifql);
        $fb_obj = json_decode($json);
        $fb_obj = $fb_obj[0];
        $like = $fb_obj->like_count;
        /////////////////////
        $blog->like = $like;
        $blog->save();
        $relateblog = Blog::whereHas('subjectblogs', function ($q) {
            $q->where('id', '=', 32);
        })->where('destinationpoint_id', $blog->destinationpoint_id)->where('id', '!=', $blog->id)->take(4)->get();
        return View::make('front.eventpost.detail', compact('blog', 'relateblog'));
    }

    public function applyEventPost()
    {
        $selectdestination = DestinationPoint::all()->pluck('title', 'id');
        $user = Auth::user();
        if ($user != null) {
            $eventposts = Blog::where('author', $user->id)->whereHas('subjectblogs', function ($q) {
                $q->where('id', '=', 32);
            })->get();
            return View::make('front.eventpost.apply', compact('selectdestination', 'eventposts'));
        } else {
            return redirect('userhome?v=2');
        }
    }

    public function clearDemo()
    {
        session()->put('demo', 'false');
        return $this->index(false);
    }

    public function addWishlist(Request $request)
    {
        $wishlist = Cookie::get('wishlist');
        $wishlist = $wishlist == null ? '' : $wishlist;
        if ($wishlist == '') {
            $wishlist_arr = array();
        } else {
            $wishlist_arr = explode(';', $wishlist);
        }
        if ($request->ajax()) {
            $arrlinks = (explode('/', URL::previous()));
            $tour = Tour::whereSlug($arrlinks[3])->first();
            if (!in_array($tour->slug, $wishlist_arr)) {
                $wishlist_arr[] = $tour->slug;
                $new_wishlist = implode(';', $wishlist_arr);
                Cookie::queue('wishlist', $new_wishlist, '1647489093');
                return response()->json([
                    'status' => '1',
                    'message' => 'Thêm sản phẩm yêu thích thành công',
                    'total_wishlist' => count($wishlist_arr)
                ]);
            } else {
                return response()->json([
                    'status' => '1',
                    'message' => 'Tour đã ở trong danh sách sản phẩm yêu thích',
                    'total_wishlist' => count($wishlist_arr)
                ]);
            }

        }
        return response()->json([
            'status' => '0',
            'message' => 'Ajax Request',
            'total_wishlist' => count($wishlist_arr)
        ]);
    }

    public function deleteWishlist(Request $request)
    {
        Cookie::queue('wishlist', '', '1647489093');
    }

    public function showWishList()
    {

    }

    public function socialCounter()
    {
        // Count FB like
        $fql = "SELECT url, normalized_url, share_count, like_count, comment_count, ";
        $fql .= "total_count, commentsbox_count, comments_fbid, click_count FROM ";
        $fql .= "link_stat WHERE url = '" . asset('/') . "'";
        $apifql = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);
        $json = file_get_contents($apifql);
        $fb_obj = json_decode($json);
        $fb_obj = $fb_obj[0];
        $like_fb = $fb_obj->like_count;
        // Count Google
        $data['facebook_like'] = $like_fb;
    }

    public function clearcache()
    {
        Artisan::call('cache:clear');
        Artisan::call('route:cache');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        return "Cache is cleared";
    }

    public function showPage($slug)
    {
        $configpage = Config::where('is_page', 1)->where('type', 'like', '%' . $slug . '%')->first();
        return View::make('front.page', compact('configpage'));
    }

    public function sendConsult(App\Http\Requests\ConsultRequest $request)
    {
        if ($request->ajax()) {
            $inputs = Input::all();
            $contact = new App\Models\Contact();
            $contact->phone = $inputs['phone'];
            $contact->tour_id = $inputs['tour_id'];
            $contact->user_id = auth()->id();
            $contact->is_check = 0;
            $contact->save();
            return 'Ok';
        } else {
            return 'You don\'t have right';
        }
    }

    public function booking(Request $request)
    {
        $cart = Cart::content();
        if(count($cart)=== 0 ){
            return redirect('/');
        }
        $tour = $cart->first()->options['tour'] ;
        $cartItem = $cart->first()->options;
        $startdate =  StartDate::find($cart->first()->id);
        return View::make('front.booking',compact('tour','cartItem','startdate'));
    }

    public function GetTourResult(GetTourResultRequest $request)
    {
        try {
            $inputs = $request->all();
            $isBooking  = !isset($inputs['tour_startdate']);
            if($isBooking){
                $this->BookingTour($request);
            }
            extract($inputs, EXTR_SKIP);
            $startdate = StartDate::find($tour_startdate_id);
            $addings = \GuzzleHttp\json_decode($startdate->addings);
            $tour_result = new \stdClass();
            $tour_results = [];
            $tour_result->total_adult_price = $tour_adult * $startdate->adult_price;
            $tour_result->total_child_price = $tour_child * $startdate->child_price;
            $tour_result->total_baby_price = $tour_baby * $startdate->baby_price;
            $tour_result->standard_price = 0;
            $tour_result->total_addings = [];
            $tour_result->total_amount = $tour_result->total_adult_price + $tour_result->total_child_price + $tour_result->total_baby_price ;
            $tour_results[] = [
                'Người lớn',
                null ,
                $tour_adult ,
                $startdate->adult_price ,
                $tour_result->total_adult_price
            ];
            $tour_results[] = [
                'Trẻ em',
                null ,
                $tour_child ,
                $startdate->child_price ,
                $tour_result->total_child_price
            ];
            $tour_results[] = [
                'Em bé',
                null ,
                $tour_baby ,
                $startdate->child_price ,
                $tour_result->total_baby_price
            ];

            foreach ($addings as $index => $adding) {
                if ($tour_standard) {
                    if ($adding->obj * 1 === $tour_standard * 1) {
                        $tour_result->total_addings[] = $adding ;
                        $tour_result->standard_price = $adding->price * 1;
                        $tour_result->total_amount += $tour_adult*$tour_result->standard_price;
                        $tour_results[] = [
                            'Tiêu chuẩn (sao)',
                            null ,
                            $tour_adult ,
                            $tour_result->standard_price ,
                            $tour_adult*$tour_result->standard_price
                        ];
                    }
                }
            }
            foreach ($addings as $index => $adding) {
                if($adding->required === 'true' && $adding->obj*1 <=2 ){
                    $tour_result->total_addings[] = $adding ;
                    $total_person = 0;
                    if($adding->obj*1 === 0){
                        $total_person = $tour_adult+$tour_child+$tour_baby ;
                    }
                    if($adding->obj*1 === 1){
                        $total_person = $tour_child ;
                    }
                    if($adding->obj*1 === 2){
                        $total_person = $tour_baby ;
                    }
                    $total_price = $adding->price* $total_person ;
                    $tour_result->total_amount += $total_price ;
                    $tour_results[] = [
                            $adding->name,
                            'Có' ,
                            $total_person ,
                            $adding->price ,
                            $total_price
                    ];
                }
            }

            return \GuzzleHttp\json_encode($tour_results);
        } catch (Exception $ex) {
            return 'fail';
        }
    }
    public function BookingTour(GetTourResultRequest $request){
        try{
            $inputs = $request->all();
            extract($inputs, EXTR_SKIP);
            $startdate = StartDate::find($tour_startdate_id);
            $addings = \GuzzleHttp\json_decode($startdate->addings);
//            $row = Cart::search(function ($cartItem, $rowId) use ($startdate) {
//                return $cartItem->id === $startdate->id;
//            });
            $isAuthenticated  = \Illuminate\Support\Facades\Auth::guest()?true:false;
            $user = Auth::user();
            Cart::destroy();
            //if(count($row)=== 0) {
                Cart::add(array('id' => $startdate->id,
                        'name' => $startdate->tour->title,
                        'qty' => $tour_adult,
                        'price' => $startdate->adult_price ,
                        'options' => array(
                            'adult' => $tour_adult,
                            'child' => $tour_child,
                            'baby' => $tour_baby,
                            'standard' => $tour_standard,
                            'tour' => $startdate->tour ,
                        )
                    )
                );
            //}
            return 'ok';

        } catch (Exception $ex){
            return 'fail';
        }
    }
    public function CheckPromotionCode (Request $request) {
        $inputs = $request->all();
        if(isset($inputs['code'])&& $inputs['code']!==''){
            $promotionCode = PromotionCode::where('code' , $inputs['code'])->first();
            if($promotionCode === null){
                return 'fail';
            } else {
                $cart = Cart::content();
                if(count($cart)=== 0 ){
                    return 'fail';
                }
                $cart = $cart->first();
                Cart::destroy();
                $startdate =  StartDate::find($cart->id);
                $cartItem = $cart->options;
                Cart::add(array('id' => $cart->id,
                        'name' => $startdate->tour->title,
                        'qty' => $cartItem['adult'],
                        'price' => $startdate->adult_price ,
                        'options' => array(
                            'promotioncode'=> $promotionCode->code,
                            'adult' => $cartItem['adult'],
                            'child' => $cartItem['child'],
                            'baby' => $cartItem['baby'],
                            'standard' => $cartItem['standard'],
                            'tour' => $cartItem['tour']
                        )
                    )
                );
                return 'ok';
            }
        }
    }
    public function ConfirmOrder (Request $request) {
        try {
            DB::beginTransaction();
            $expiresAt = Carbon::now()->addMinutes(10);
            $eventtimeconfig = Cache::remember('eventtimeconfig', $expiresAt, function () {
                return Config::where('type', 'like', 'golden-hour')->first();
            });
            $eventtime =  Carbon::createFromFormat('Y/m/d H:i:s', strip_tags($eventtimeconfig->content));
            $eventtimeend =  $eventtime->copy()->addHour(2);
            $now = Carbon::now();
            $inEvent = $now->between($eventtime, $eventtimeend);

            $cart = Cart::content();
            if(count($cart)=== 0 ){
                return 'fail';
            }
            $tour = $cart->first()->options['tour'] ;
            $cartItem = $cart->first()->options;
            $startdate =  StartDate::find($cart->first()->id);

            $tour = $startdate->tour;
            $isGolden = $tour->isGolden();

            $addings = \GuzzleHttp\json_decode($startdate->addings);
            /* Tính đơn hàng */
            $total = 0;
            $total_adult_price = $cartItem['adult'] * $startdate->adult_price;
            $total_child_price = $cartItem['child'] * $startdate->child_price;
            $total_baby_price = $cartItem['baby'] * $startdate->baby_price;
            $total = $total_adult_price+$total_child_price+$total_baby_price;
            $total_seat = $cartItem['adult']+$cartItem['child'];
            $adding_seat = 0;
            $tour_results = [];
            $order_addings = new \stdClass();
            $order_addings->adding_standard = '';
            $order_addings->adding_standard_price = 0;
            $order_addings->adding_required = [];
            $addingamount = 0;
            // phụ thu tiêu chuẩn
            $adding_standard = 0 ;
            // phụ thu bắt buộc
            $adding_required = 0;
            foreach ($addings as $index => $adding) {
                if ($cartItem['standard']) {
                    if ($adding->obj * 1 === $cartItem['standard'] * 1) {
                        $adding_standard = $cartItem['adult']*($adding->price * 1);
                        $addingamount += $adding_standard;
                        /* adding standard */
                        $order_addings->adding_standard = $cartItem['standard'];
                        $order_addings->adding_standard_price = $adding_standard;
                        /*******************/
                        $tour_results[] = [
                            'Tiêu chuẩn (sao)',
                            null ,
                            $cartItem['adult'] ,
                            $adding->price * 1 ,
                            $adding_standard
                        ];
                    }
                }
                if($adding->required === 'true' && $adding->obj*1 <=2 ){
                    $total_person = 0;
                    if($adding->obj*1 === 0){
                        $total_person = $cartItem['adult']+$cartItem['child']+$cartItem['baby'] ;
                    }
                    if($adding->obj*1 === 1){
                        $total_person = $cartItem['child'] ;
                    }
                    if($adding->obj*1 === 2){
                        $total_person = $cartItem['baby'] ;
                    }
                    $total_price = $adding->price* $total_person ;
                    $adding_required += $total_price ;
                    $addingamount += $total_price;
                    /* adding standard */
                    $adding->total_price = $total_price;
                    $order_addings->adding_required[] = $adding ;
                    /*******************/
                    $tour_results[] = [
                        $adding->name,
                        'Có' ,
                        $total_person ,
                        $adding->price ,
                        $total_price
                    ];
                }
            }
            $total += $addingamount;

            /*****************/
            $user = \Illuminate\Support\Facades\Auth::user();
            $new_order  = new Order();
            $new_order->customer_id = $user->id;
            $new_order->staff_id = $tour->user_id;
            $new_order->tourstaff_id = $tour->user_id;
            $new_order->startdate_id = $startdate->id;
            $new_order->price = $startdate->adult_price;
            $new_order->status = 1 ;
            $new_order->online = 1 ;
            $new_order->adult = $cartItem['adult'] ;
            $new_order->child = $cartItem['child'] ;
            $new_order->baby = $cartItem['baby'] ;
            $new_order->total = $total ; // giá chưa trừ mã giảm giá hay khuyến mãi ;
            $new_order->addings = \GuzzleHttp\json_encode($order_addings);
            if(isset($cartItem['promotioncode'])&& $cartItem['promotioncode']!==''){
                $promotion_code  = PromotionCode::where('code',$cartItem['promotioncode'])->whereNull('order_id')->first(); // chỉ áp dụng 1 mã giảm giá 1 lần
                $new_order->discount = $promotion_code->value*1;
                $new_order->discount_reason += '| Mã giảm giá '.strtoupper($promotion_code.code);
            }
            $order_id = $new_order->save();
            if(isset($cartItem['promotioncode'])&& $cartItem['promotioncode']!==''){
                $promotion_code->order_id = $order_id ;
                $promotion_code->startdate_id = $startdate->id ;
                $promotion_code->save();
            }
            if($inEvent && $isGolden){
                $tmp_sd = StartDate::whereId($startdate->id)->withCount(['promotion_codes'=>function($pc) use($cartItem){
                    $pc->whereNull('order_id');
                }])->first();
                $seat = $cartItem['adult']*1 >  $tmp_sd->promotion_codes_count*1 ?  $tmp_sd->promotion_codes_count*1 :$cartItem['adult']*1 ;
                $discountgold = round($seat* $tmp_sd->percent/100 * $tmp_sd->adult_price) ;
                $new_order->discountgold = $discountgold  ;
                if($seat > 0){
                    foreach ($tmp_sd->promotion_codes as $index=>$pc){
                        $pc->order_id = $new_order->id ;
                        $pc->save();
                    }
                }
                $new_order->save();
            }
            Cart::destroy();
            DB::commit();
            return 'ok';
        }catch (Exception $ex ){
            DB::rollback();
            return 'fail';
        }

    }
    public function GetAddings (Request $request) {
        try {
            $inputs = $request->all();
            if(isset($inputs['id'])){
                $startdate = StartDate::find($inputs['id']);
                return $startdate->addings;
            }
            return 'fail';
        }catch (Exception $ex ){
            return 'fail';
        }
    }
    public function GetStartdate (Request $request) {
        try {
            $inputs = $request->all();
            if(isset($inputs['id'])){
                $startdate = StartDate::find($inputs['id']);
                $startdate->addings = '';
                return $startdate;
            }
            return 'fail';
        }catch (Exception $ex ){
            return 'fail';
        }
    }
}
