<?php namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\HotelCharacter;
use App\Models\HotelType;
use App\Models\PromotionCode;
use App\Models\Room;
use App\Models\Transport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Adding;
use App\Models\AddingCate;
use Auth;
use App\Models\SubjectBlog;
use App\Models\Banner;
use App\Models\DestinationPoint;
use App\Models\SightPoint;
use App\Models\SourcePoint;
use App\Models\Blog;
use App\Models\StartDate;
use App\Models\Tour;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManagerStatic as Image;
class FunctionController extends Controller {

    public function __construct()
    {
        // must be admin function except
        $this->middleware('admin',['except'=>array('showSightPoint','blogSearch','getTourByDestinationPoint','getStartdate','delCart','showStartdate','closeHomeModal')]);
    }
	public function checkTitle()
	{
        $inputs = Input::all();
        $title = $inputs['title'];
        $slug = khongdaurw($inputs['title']);
        $result = 0;
        $result  += Banner::where('title','like',$title)->count();
        $result  += Blog::where('title','like',$title)->orWhere('slug','like',$slug)->count();
        $result  += DestinationPoint::where('title','like',$title)->orWhere('slug','like',$slug)->count();
        $result  += SightPoint::where('title','like',$title)->count();
        $result  += SourcePoint::where('title','like',$title)->count();
        $result  += Tour::where('title','like',$title)->orWhere('slug','like',$slug)->count();
		return $result;
	}
    public function showSightPoint()
    {
        $inputs = Input::all();
        $id = $inputs['id'];
        if(is_numeric($id))
        {
            $sightpoint = SightPoint::findOrFail($id);
            $sightpoint->destinationpointname = $sightpoint->destinationpoint->title;
            //dd($sightpoint->toJson());
            return $sightpoint->toJson();
        }
    }
    public function delOldStartDate()
    {
        $inputs = Input::all();
        $id = $inputs['id'];
        if(is_numeric($id))
        {
            $transports = Transport::where('startdate_id',$id)->get();
            foreach($transports as $transport){
                $transport->delete();
            }
            $startdate = StartDate::findOrFail($id);
            $startdate->delete();
            return '0';
        }
    }
    public function fixslug()
    {
        $sightpoints = SightPoint::all();
        foreach($sightpoints as $sightpoint)
        {
            $sightpoint->slug = khongdaurw($sightpoint->title);
            $sightpoint->save();
        }
    }
    public function getTourByDestinationPoint(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        if($request->ajax())
        {
            if(is_numeric($request['id'])) {
                $destinationpoint = DestinationPoint::findOrFail($request['id']);
                if ($role == 'admin') {
                    $tours = Tour::whereHas('destinationpoints', function ($q) use ($destinationpoint) {
                        $q->whereId($destinationpoint->id);
                    })->orderBy('title')->pluck('title', 'id')->all();
                } else {
                    $tours = Tour::where('user_id', 'like', $user->id)->whereHas('destinationpoints', function ($q) use ($destinationpoint) {
                        $q->whereId($destinationpoint->id);
                    })->orderBy('title')->pluck('title', 'id')->all();
                }
            } else {
                if ($role == 'admin') {
                    $tours = Tour::orderBy('title')->pluck('title', 'id')->all();
                } else {
                    $tours = Tour::where('user_id', 'like', $user->id)->orderBy('title')->pluck('title', 'id')->all();
                }
            }
            return view('front.staff.partials.startdatetour',compact('tours'));
        } else {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
    public function getStartdate(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        if($request->ajax())
        {
            if(is_numeric($request['id']))
            {
                $startdate = StartDate::find($request['id']);
                $addings = $startdate->addings;
                $addingcates = AddingCate::all();
                return view('front.staff.partials.editmodal',compact('startdate','addings','addingcates'));
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
    public function showStartdate(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->slug;

        if($request->ajax())
        {
            if(is_numeric($request['id']))
            {
                $dt = new Carbon('yesterday');
                if($role == 'admin'){
                    $startdates = Tour::find($request['id'])->startdates()->orderBy('startdate','ASC')->get();
                } else {
                    $startdates = Tour::find($request['id'])->startdates()->where('startdate','>',$dt)->orderBy('startdate','ASC')->get();
                }
//                $str= '<option value="">Chọn khởi hành</option>';
//                foreach($startdates as $sd)
//                {
//                    $str .= '
//                    <option value="'.$sd->id.'">'.date_format(date_create($sd->startdate),'d/m/Y').'</option>
//                    ';
//                }
                return \GuzzleHttp\json_encode($startdates);
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
    public function delAdding(Request $request)
    {
        $user = Auth::user();
        $role = $user->role->slug;
        if($request->ajax())
        {
            if(is_numeric($request['id']))
            {
                Adding::destroy($request['id']);
                return 'ok';
            }
        }
        else
        {
            return 'Có lỗi! Vui lòng liên hệ administrators !';
        }
    }
    public function delCart(Request $request)
    {
        $inputs = Input::all();
        $rid = $inputs['rid'];
        if($request->ajax())
        {
            Cart::remove($rid);
            return 'ok';
        }
        return 'fail';
    }
    public function addHotelType(Request $request){
        $inputs = Input::all();
        $title = $inputs['title'];
        if($request->ajax())
        {
            $hoteltype = new HotelType();
            $hoteltype->title = $title;
            $hoteltype->save();
            $selecthoteltype = HotelType::all();
            return view('back.partials.typelist',compact('selecthoteltype'));
        }
        return 'fail';
    }
    public function delHotelType(Request $request){
        $inputs = Input::all();
        $typeid = $inputs['typeid'];
        if($request->ajax())
        {
            $deleteRows = HotelCharacter::where('type_id','=',$typeid)->delete();
            HotelType::destroy($typeid);
            $selecthoteltype = HotelType::all();
            return view('back.partials.typelist',compact('selecthoteltype'));
        }
        return 'fail';
    }
    public function editHotelType(Request $request){
        $inputs = Input::all();
        $typeid = $inputs['typeid'];
        $title = $inputs['title'];
        if($request->ajax())
        {
            $hoteltype = HotelType::find($typeid);
            $hoteltype->title = $title;
            $hoteltype->save();
            $selecthoteltype = HotelType::all();
            return view('back.partials.typelist',compact('selecthoteltype'));
        }
        return 'fail';
    }
    public function addHotelCharacter(Request $request){
        $inputs = Input::all();
        $typeid = $inputs['typeid'];
        $title = $inputs['title'];
        if($request->ajax())
        {
            $hotelcharacter = new HotelCharacter();
            $hotelcharacter->title = $title;
            $hotelcharacter->type_id = $typeid;
            $hotelcharacter->save();
            $selecthoteltype = HotelType::all();
            return view('back.partials.typelist',compact('selecthoteltype'));
        }
        return 'fail';
    }
    public function delHotelCharacter(Request $request){
        $inputs = Input::all();
        $typeid = $inputs['typeid'];
        if($request->ajax())
        {
            HotelCharacter::destroy($typeid);
            $selecthoteltype = HotelType::all();
            return view('back.partials.typelist',compact('selecthoteltype'));
        }
        return 'fail';
    }
    public function editHotelCharacter(Request $request){
        $inputs = Input::all();
        $typeid = $inputs['typeid'];
        $title = $inputs['title'];
        if($request->ajax())
        {
            $hoteltype = HotelCharacter::find($typeid);
            $hoteltype->title = $title;
            $hoteltype->save();
            $selecthoteltype = HotelType::all();
            return view('back.partials.typelist',compact('selecthoteltype'));
        }
        return 'fail';
    }
    public function delHotelRoom(Request $request){
        $inputs = Input::all();
        $idroom= $inputs['idroom'];
        if($request->ajax())
        {
            $room = Room::find($idroom);
            $countrows = $room->images()->delete();
            $room->delete();
            return 'ok';
        }
        return 'fail';
    }
    function changePromotion(Request $request){
        $user  = Auth::user();
        if($user->role->slug == 'admin') {
            $inputs = Input::all();
            if ($request->ajax()) {
                $countpromo = PromotionCode::where('startdate_id', '=', $inputs['startdate_id'])->count();
                if ($countpromo == 0) {
                    // add new
                    for ($i = 0; $i < $inputs['promotion']; $i++) {
                        $promotioncode = new PromotionCode();
                        $promotioncode->startdate_id = $inputs['startdate_id'];
                        $promotioncode->code = str_random(15);
                        $promotioncode->save();
                    }
                } else {
                    if ($countpromo < $inputs['promotion']) {
                        $newpromo = $inputs['promotion'] - $countpromo;
                        ///add
                        for ($i = 0; $i < $newpromo; $i++) {
                            $promotioncode = new PromotionCode();
                            $promotioncode->startdate_id = $inputs['startdate_id'];
                            $promotioncode->code = str_random(15);
                            $promotioncode->save();
                        }
                    } else {
                        $promotioncodes = PromotionCode::where('startdate_id', '=', $inputs['startdate_id'])->get();

                        $delpromo = abs($inputs['promotion'] - $countpromo);
                        $count = 0;
                        foreach ($promotioncodes as $code) {
                            if ($code->order_id == null && $count < $delpromo) {
                                $code->delete();
                                $count++;
                            }
                        }
                    }
                }
                return 'ok';
            }
            return 'fail';
        }
    }
    public function changeEvent(Request $request){
        $inputs = Input::all();
        $startdate_id= $inputs['startdate_id'];
        if($request->ajax())
        {
            $startdate = StartDate::find($startdate_id);
            $startdate->isEvent = $inputs['val']=='true'?1:0;
            $startdate->save();
            return 'ok';
        }
        return 'fail';
    }
    public function changePercent(Request $request){
        $inputs = Input::all();
        $startdate_id= $inputs['startdate_id'];
        if($request->ajax())
        {
            $startdate = StartDate::find($startdate_id);
            $startdate->percent = $inputs['val'];
            $startdate->save();
            return 'ok';
        }
        return 'fail';
    }
    public function updateTourAds(Request $request){
        $inputs = Input::all();
        $tour_name = $inputs['tour_name'];
        $tour_ads = $inputs['tour_ads'];
        if($request->ajax())
        {
            $tour = Tour::where('title','like',"%" . $tour_name . "%")->first();
            $tour->tour_ads = $tour_ads;
            $tour->save();
            return 'ok';
        }
        return 'fail';
    }
    public function flushcache(){
        Cache::flush();
        return redirect('admin');
    }
    public function closeHomeModal(Request $request){
        if($request->ajax())
        {
            session()->push('modal_home_close', 'true');
        }
    }
    public function UploadImage(Request $request){
        if($request->ajax())
        {
            if($request->hasFile('Files')){
                $image = $request->file('Files');
                $filename = $image->getClientOriginalName() ;
                // Image::make($image)->resize(300, 300)->save( public_path('/image/blog/' . $filename ) );
                $path  = public_path('/image/blog'  );
                if($request->has('class')){
                    $path =  public_path('/image/'.$request->class);
                }
                //dd(File::exists($path));
                if(!File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                Image::make($image)->save( $path .'/'. $filename);
            };
            return 'ok';
        }
        return 'fail';
    }
}
