<?php
namespace App\Repositories;


use App\Models\DestinationPoint;
use App\Models\Detail;
use App\Models\SightPoint;
use App\Models\SourcePoint;
use App\Models\StartDate;
use App\Models\SubjectTour;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class   TourRepository extends BaseRepository {
    protected $sightpoint;
    protected $destinationpoint;
    protected $tour;
    public $user;
    protected $detail;
    protected $sourcepoint;
    protected $startdate;
    public $subjecttour;
    public function __construct(
        Tour $tour ,
        DestinationPoint $destinationpoint ,
        User $user ,
        Detail $detail ,
        SourcePoint $sourcepoint ,
        StartDate $startdate ,
        SubjectTour $subjecttour ,
        SightPoint $sightpoint
    )
    {
        $this->tour = $tour;
        $this->destinationpoint = $destinationpoint;
        $this->user = $user;
        $this->detail = $detail;
        $this->sourcepoint = $sourcepoint;
        $this->startdate = $startdate;
        $this->subjecttour = $subjecttour;
        $this->sightpoint = $sightpoint;
    }
    public function index($n, $userid,$subjecttourid,$search)
    {
        $user  = \Auth::user();
        $tours = $this->tour;
        if ($subjecttourid!='')
        {
            //$subjecttournode = $this->subjecttour->find($subjecttourid)->getDescendantsAndSelf()->pluck('id');
            $tours  = $this->subjecttour->findOrFail($subjecttourid)->tours();
        }
        if ($userid!='')
        {

            $tours = $tours->with('user')->whereHas('user', function ($q) use ($userid) {
            $q->whereId($userid);
            });
        }
        if ($search!='')
        {
            $search = trim(khongdaurw($search),'-');
            $tours = $tours->where('slug','like','%'.$search.'%');
        }
        if($user->role->slug == 'admin'){
            return $tours->latest()->paginate($n);
        } else {
            return $tours->where('user_id',$user->id)->latest()->paginate($n);
        }
    }
    public function count($destinationpointid = null)
    {
        if($destinationpointid)
        {
            return $this->sightpoint
                ->whereHas('destinationpoint', function($q) use($destinationpointid) {
                    $q->where('id','like',$destinationpointid);
                })->count();
        }

        return $this->model->count();
    }
    public function counts()
    {
        $destinationpoints = $this->destinationpoint->all();
        $counts = array();
        foreach ($destinationpoints as $destinationpoint) {
            $counts[ $destinationpoint->id ] = $this->count($destinationpoint->id);
        }
        $counts['total'] = array_sum($counts);

        return $counts;
    }
    public function create()
    {
        $outbound_sub = SubjectTour::where('isOutbound',1)->get()->pluck('id');
        $selectdestination = $this->destinationpoint->orderBy('title')->get()->pluck('title', 'id');
        $selectsource =  $this->sourcepoint->orderBy('title')->get()->pluck('title','id');
        $selectsubject = $this->subjecttour->getNestedList('title', null , ' ',true);
        $selectuser = $this->user->where('role_id','=','2')->pluck('fullname','id');
        //dd($selectsource);
        return compact('outbound_sub','selectdestination','selectsource','selectsubject','selectuser');
    }
    public function store($inputs,$strimg )
    {
        $user  = \Auth::user();
        if(isset($inputs['subjecttours'])) {
            $subjecttours = $inputs['subjecttours'];
        } else {
            $subjecttours = array();
        }
        if(isset($inputs['destinationpoints'])) {
            $destinationpoints = $inputs['destinationpoints'];
        } else {
            $destinationpoints = array();
        }
        if(isset($inputs['sightpoints'])) {
            $sightpoints = $inputs['sightpoints'];
        } else {
            $sightpoints = array();
        }
        if(isset($inputs['sightpointtickets'])) {
            $sightpointtickets = $inputs['sightpointtickets'];
        } else {
            $sightpointtickets = array();
        }
        //startdates fields
        $startdates = $inputs['startdate'];
        $trafficstartdates = $inputs['traffic-startdate'];
        $seats = $inputs['seat'];
        $isOutbound = $inputs['isOutbound'];
        $addings =$inputs['adding'];
        //details fields
        $days = $inputs['day'];
        $titledetails = $inputs['title-details'];
        $imageslinks = $inputs['images-link'];
        $end_images = $inputs['end_images'];
        //create tour object
        $tour = new $this->tour;
        $tour->isOutbound = $isOutbound;
        $tour->sourcepoint_id = $inputs['sourcepoint'];
        $tour->title = $inputs['title'];
        $tour->period = $inputs['period'];
        $tour->traffic = $inputs['traffic'];

        if($user->role->slug=='admin') {
            $tour->user_id = isset($inputs['user'])?$inputs['user']:$user->id;
        } else {
            $tour->user_id = $user->id;
        }
        $tour->slug =$inputs['slug']==''?khongdaurw($inputs['title']):khongdaurw($inputs['slug']);
        $tour->end_images = implode(';',$end_images);
        $tour->description = $inputs['description'];
        $tour->notinclude = $inputs['notinclude'];
        $tour->reside = $inputs['reside'];
        $tour->ticket = $inputs['ticket'];
        $tour->meal = $inputs['meal'];
        $tour->basething = $inputs['basething'];
        $tour->notetraffic = $inputs['notetraffic'];
        $tour->guide = $inputs['guide'];
        $tour->galastage = $inputs['galastage'];
        $tour->childstipulate = $inputs['childstipulate'];
        $tour->buycancelstipulate = $inputs['buycancelstipulate'];
        $tour->payment = $inputs['payment'];
        $tour->insurrance = $inputs['insurrance'];
        $tour->note = $inputs['note'];
        $tour->homepage  = isset($inputs['homepage'])?'1':'0';
        $tour->status = isset($inputs['status'])?'1':'0';
        $tour->isSuggest = isset($inputs['suggest'])?'1':'0';
        $tour->starhotel = $inputs['starhotel'];
        $tour->images = $strimg;
        $tour->takeoff = $inputs['takeoff'];
        $tour->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $tour->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $tour->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        // makeing pivot table
        $tour->subjecttours()->attach($subjecttours);
        $tour->destinationpoints()->attach($destinationpoints);
        $tour->sightpoints()->attach($sightpoints);
        $tour->sightpointtickets()->attach($sightpointtickets);
        $tour->dp_name = join(' - ',$tour->destinationpoints()->pluck('title')->toArray());
        $tour->save();
        //new startdate objects
        for($i = 0 ;$i <count($startdates);$i++){
            $startdate = new $this->startdate;
            $startdate->tour_id = $tour->id;
            $startdate->startdate = Carbon::createFromFormat('d/m/Y',$startdates[$i]);
            $startdate->traffic = $trafficstartdates[$i];
            $startdate->seat = $seats[$i];
            $startdate->adding =$addings[$i];
            $startdate->save();
        }
        for($i = 0 ;$i <count($days);$i++){
            $detail = new $this->detail;
            $detail->tour_id = $tour->id;
            $detail->day = $days[$i];
            $detail->title = $titledetails[$i];
            $detail->image = $imageslinks[$i];
            $detail->content = $inputs['content-'.($i+1)];
            $detail->save();
        }
    }
    public function edit($id)
    {
        $outbound_sub = SubjectTour::where('isOutbound',1)->get()->pluck('id')->toArray();
        $tour = $this->tour->findOrFail($id);
        $selectdestination = $this->destinationpoint->all()->pluck('title', 'id');
        $selectsource =  $this->sourcepoint->all()->pluck('title','id');
        $selectsubject = $this->subjecttour->getNestedList('title', null , ' ',true);
        $selectuser = $this->user->where('role_id','=','2')->pluck('fullname','id');
        $selectedsubjecttours = $tour->subjecttours->pluck('id');
        $selecteddestinationpoints = $tour->destinationpoints->pluck('title','id');
        $selectedsightpoints = $tour->sightpoints->pluck('title','id');
        $selectedsightpointtickets = $tour->sightpointtickets->pluck('title','id');
        $startdates = $tour->startdates()->where('isEnd','!=' , 1)->orderBy('startdate','DESC')->get();
        $details = $tour->details()->orderBy('day','ASC')->get();
        $vehicles= DB::table('typevehicle')
            ->select('*')
            ->get();
        //dd($startdates);
        //dd($selecteddestinationpoints);
        return compact('vehicles','outbound_sub','selectdestination','selectsource','selectsubject','selectuser','tour','selectedsubjecttours','selecteddestinationpoints','selectedsightpoints' ,'startdates','selectedsightpointtickets','details');
    }
    public function getTourById($id , $user){
        if($user->role->slug == 'admin') {
            return  $this->tour->findOrFail($id);
        } else {
            return  $this->tour->where('user_id' , $user->id)->findOrFail($id);
        }
    }
    public function update($inputs, $id , $strimg)
    {
        //get content of details
        $user  = \Auth::user();


        // get others fields
        $isOutbound = $inputs['isOutbound'];
        if(isset($inputs['subjecttours'])) {
            $subjecttours = $inputs['subjecttours'];
        } else {
            $subjecttours = array();
        }
        if(isset($inputs['destinationpoints'])) {
            $destinationpoints = $inputs['destinationpoints'];
        } else {
            $destinationpoints = array();
        }
        if(isset($inputs['sightpoints'])) {
            $sightpoints = $inputs['sightpoints'];
        } else {
            $sightpoints = array();
        }
        if(isset($inputs['sightpointtickets'])) {
            $sightpointtickets = $inputs['sightpointtickets'];
        } else {
            $sightpointtickets = array();
        }
        //old startdates fields
        if(isset($inputs['oldidstartdate'])) {
            $oldidstartdates = $inputs['oldidstartdate'];
            $oldstartdates = $inputs['oldstartdate'];
            $oldtrafficstartdates = $inputs['oldtraffic-startdate'];
            $oldseats = $inputs['oldseat'];
            $oldaddings = $inputs['oldadding'];
        }
        //new startdates fields
        if(isset($inputs['startdate'])) {
            $startdates = $inputs['startdate'];
            $trafficstartdates = $inputs['traffic-startdate'];
            $seats = $inputs['seat'];
            $addings = $inputs['adding'];
        }
        //details fields
        $days = $inputs['day'];
        $titledetails = $inputs['title-details'];
        $imagelinks = $inputs['images-link'];
        $end_images = $inputs['end_images'];
        //create tour object
        $tour = $this->getTourById($id , $user);
        $tour->isOutbound = $isOutbound;
        $tour->sourcepoint_id = $inputs['sourcepoint'];
        $tour->title = $inputs['title'];
        $tour->slug =$inputs['slug']==''?khongdaurw($inputs['title']):khongdaurw($inputs['slug']);
        $tour->end_images = implode(';',$end_images);
        $tour->period = $inputs['period'];
        $tour->traffic = $inputs['traffic'];
        if($user->role->slug=='admin') {
            $tour->user_id = $inputs['user'];
        } else {
            $tour->user_id = $user->id;
        }
        $tour->description = $inputs['description'];
        $tour->notinclude = $inputs['notinclude'];
        $tour->reside = $inputs['reside'];
        $tour->ticket = $inputs['ticket'];
        $tour->meal = $inputs['meal'];
        $tour->basething = $inputs['basething'];
        $tour->notetraffic = $inputs['notetraffic'];
        $tour->guide = $inputs['guide'];
        $tour->galastage = $inputs['galastage'];
        $tour->childstipulate = $inputs['childstipulate'];
        $tour->buycancelstipulate = $inputs['buycancelstipulate'];
        $tour->payment = $inputs['payment'];
        $tour->insurrance = $inputs['insurrance'];
        $tour->note = $inputs['note'];
        $tour->isSuggest = isset($inputs['suggest'])?'1':'0';
        $tour->homepage  = isset($inputs['homepage'])?'1':'0';
        //$tour->price = $inputs['price'];
        //$tour->adultprice = $inputs['adultprice'];
        //$tour->pricedetail = $inputs['pricedetail'];
        $tour->status = isset($inputs['status'])?'1':'0';
        $tour->priority = $inputs['priority'];
        //$tour->star0 = $inputs['star0'];
        //$tour->star1 = $inputs['star1'];
        //$tour->star2 = $inputs['star2'];
        //$tour->star3 = $inputs['star3'];
        //$tour->star4 = $inputs['star4'];
        //$tour->star5 = $inputs['star5'];
        //$tour->rs2 = $inputs['rs2'];
        //$tour->rs3 = $inputs['rs3'];
        //$tour->rs4 = $inputs['rs4'];
        //$tour->rs5 = $inputs['rs5'];
        $tour->starhotel = $inputs['starhotel'];
        $tour->images = $strimg;
        $tour->takeoff = $inputs['takeoff'];
        $tour->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $tour->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $tour->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        //delete pivot table
        $tour->subjecttours()->detach();
        $tour->destinationpoints()->detach();
        $tour->sightpoints()->detach();
        $tour->sightpointtickets()->detach();
        // making new pivot table
        $tour->subjecttours()->attach($subjecttours);
        $tour->destinationpoints()->attach($destinationpoints);
        $tour->sightpoints()->attach($sightpoints);
        $tour->sightpointtickets()->attach($sightpointtickets);
        ///////////////////////////////
        $tour->dp_name = join(' - ',$tour->destinationpoints()->pluck('title')->toArray());
        $tour->save();
        //edit old startdate objects
//        if(isset($inputs['oldidstartdate'])) {
//            for ($i = 0; $i < count($oldidstartdates); $i++) {
//                //if (checkValidDate($oldstartdates[$i]))
//                //{
//                $startdate = $this->startdate->findOrFail($oldidstartdates[$i]);
//                $startdate->tour_id = $tour->id;
//                $startdate->startdate = Carbon::createFromFormat('d/m/Y', $oldstartdates[$i]);
//                $startdate->traffic = $oldtrafficstartdates[$i];
//                $startdate->seat = $oldseats[$i];
//                $startdate->adding = $oldaddings[$i];
//                $startdate->save();
//                //}
//            }
//        }
        //new startdate objects
//        if(isset($startdates)) {
//            for ($i = 0; $i < count($startdates); $i++) {
//                if (checkValidDate($startdates[$i])) {
//                    $startdate = new $this->startdate;
//                    $startdate->tour_id = $tour->id;
//                    $startdate->startdate = Carbon::createFromFormat('d/m/Y', $startdates[$i]);
//                    $startdate->traffic = $trafficstartdates[$i];
//                    $startdate->seat = $seats[$i];
//                    $startdate->adding = $addings[$i];
//                    $startdate->save();
//                }
//            }
//        }
        //delete detail objects;
        $tour->details()->delete();
        //new detail objects
        for($i = 0 ;$i <count($days);$i++){
            $detail = new $this->detail;
            $detail->tour_id = $tour->id;
            $detail->day = $days[$i];
            $detail->title = $titledetails[$i];
            $detail->image =  $imagelinks[$i];
            $detail->content = $inputs['content-'.($i+1)];
            $detail->save();
        }

    }
    public function copyTour($id,$inputs)
    {
        $sourcetour = $this->tour->find($id);
        if($sourcetour->title!=$inputs['title']) {
            if(isset($inputs['subjecttours'])) {
                $subjecttours = $inputs['subjecttours'];
            } else {
                $subjecttours = array();
            }
            if(isset($inputs['destinationpoints'])) {
                $destinationpoints = $inputs['destinationpoints'];
            } else {
                $destinationpoints = array();
            }
            if(isset($inputs['sightpoints'])) {
                $sightpoints = $inputs['sightpoints'];
            } else {
                $sightpoints = array();
            }
            if(isset($inputs['sightpointtickets'])) {
                $sightpointtickets = $inputs['sightpointtickets'];
            } else {
                $sightpointtickets = array();
            }
            $imagelinks = $inputs['images-link'];
            $end_images = $inputs['end_images'];
            $tour = new $this->tour;
            $tour->sourcepoint_id = $inputs['sourcepoint'];
            $tour->title = $inputs['title'];
            $tour->period = $inputs['period'];
            $tour->traffic = $inputs['traffic'];
            $tour->user_id = $inputs['user'];
            $tour->slug = $inputs['slug']==''?khongdaurw($inputs['title']):khongdaurw($inputs['slug']);
            $tour->description = $inputs['description'];
            $tour->notinclude = $inputs['notinclude'];
            $tour->reside = $inputs['reside'];
            $tour->ticket = $inputs['ticket'];
            $tour->meal = $inputs['meal'];
            $tour->basething = $inputs['basething'];
            $tour->notetraffic = $inputs['notetraffic'];
            $tour->guide = $inputs['guide'];
            $tour->galastage = $inputs['galastage'];
            $tour->childstipulate = $inputs['childstipulate'];
            $tour->buycancelstipulate = $inputs['buycancelstipulate'];
            $tour->payment = $inputs['payment'];
            $tour->note = $inputs['note'];
            $tour->homepage = isset($inputs['homepage']) ? '1' : '0';
            $tour->price = $inputs['price'];
            $tour->adultprice = $inputs['adultprice'];
            $tour->status = isset($inputs['status']) ? '1' : '0';
            $tour->isSuggest = isset($inputs['suggest']) ? '1' : '0';
            $tour->star0 = $inputs['star0'];
            $tour->star1 = $inputs['star1'];
            $tour->star2 = $inputs['star2'];
            $tour->star3 = $inputs['star3'];
            $tour->star4 = $inputs['star4'];
            $tour->star5 = $inputs['star5'];
            $tour->rs2 = $inputs['rs2'];
            $tour->rs3 = $inputs['rs3'];
            $tour->rs4 = $inputs['rs4'];
            $tour->rs5 = $inputs['rs5'];
            $tour->starhotel = $inputs['starhotel'];
            $tour->end_images = $sourcetour->end_images;
            $tour->images = $sourcetour->images;
            $tour->takeoff = $inputs['takeoff'];
            $tour->seokeyword = $inputs['seokeyword'] == '' ? trim(khongdau($inputs['title'])) : $inputs['seokeyword'];
            $tour->seodescription = $inputs['seodescription'] == '' ? strip_tags($inputs['description']) : $inputs['seodescription'];
            $tour->seotitle = $inputs['seotitle'] == '' ? trim(khongdau($inputs['title'])) : $inputs['seotitle'];
            $tour->created_at  = Carbon::now();
            $tour->save();
            // makeing pivot table
            $tour->subjecttours()->attach($subjecttours);
            $tour->destinationpoints()->attach($destinationpoints);
            $tour->sightpoints()->attach($sightpoints);
            $tour->sightpointtickets()->attach($sightpointtickets);
            //details fields
            $days = $inputs['day'];
            $titledetails = $inputs['title-details'];

            for ($i = 0; $i < count($days); $i++) {
                $detail = new $this->detail;
                $detail->tour_id = $tour->id;
                $detail->day = $days[$i];
                $detail->title = $titledetails[$i];
                $detail->image =  $imagelinks[$i];
                $detail->content = $inputs['content-' . ($i + 1)];
                $detail->save();
            }
        }
    }
    public function destroy($id)
    {
        $user = \Auth::user();
        $tour = $this->getTourById($id , $user);
        $strimages = $tour->images;
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::delete(public_path() . '/image/' . $images);
                    }
                }
            }
        }
        //thay doi tour diem den ve mac dinh
        //$tour->comments()->delete();

        $tour->delete();
    }
    public function getSightPointByDestinationPoints($ids){
        return  $this->sightpoint->whereIn('destinationpoint_id',$ids)->orderBy('title')->get();
    }
}