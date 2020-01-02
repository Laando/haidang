<?php
namespace App\Repositories;


use App\Models\DestinationPoint;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\HotelType;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class   HotelRepository extends BaseRepository {
    protected $sightpoint;
    protected $destinationpoint;
    protected $hotel;
    public $user;
    protected $sourcepoint;
    protected $startdate;
    public $subjecthotel;
    public function __construct(
        Hotel $hotel ,
        DestinationPoint $destinationpoint ,
        User $user
    )
    {
        $this->hotel = $hotel;
        $this->destinationpoint = $destinationpoint;
        $this->user = $user;
    }
    public function index($n)
    {
        $hotels = $this->hotel;
        return $hotels->orderBy('homepage','DESC')->latest()->paginate($n);

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
        $selecthoteltype = HotelType::all();
        $selectdestinationpoint = DestinationPoint::orderBy('title')->pluck('title','id');
        $selectstaff = User::where('role_id','=',2)->pluck('fullname','id');
        return compact('selecthoteltype','selectdestinationpoint','selectstaff');
    }
    public function store($inputs,$strimg)
    {

        ////////////////////////////// list the input
        $title = $inputs['title'];

        $description = $inputs['description'];
        $addess = $inputs['address'];
        $phone = $inputs['phone'];
        $fax = $inputs['fax'];
        $condition = $inputs['condition'];
        $information = $inputs['information'];
        $destinationpoint_id = $inputs['destinationpoint_id'];
        $user_id = $inputs['user_id'];
        $star = $inputs['star'];
        $checkin = $inputs['checkin'];
        $checkout = $inputs['checkout'];
        if($inputs['seokeyword']!='') {
            $seokeyword = $inputs['seokeyword'];
        } else {
            $seokeyword = khongdau($title);
        }
        if($inputs['seodescription']!='') {
            $seodescription = $inputs['seodescription'];
        } else {
            $seodescription = khongdau(strip_tags($description));
        }
        if($inputs['seotitle']!='') {
            $seotitle = $inputs['seotitle'];
        } else {
            $seotitle = $title;
        }
        ////////////////arry field
        $roomtitles = $inputs['roomtitle'];
        $persons = $inputs['person'];
        $prices = $inputs['price'];
        $p_prices = $inputs['p_price'];
        $hoteltypes = $inputs['hoteltype'];
        $hotelchars = $inputs['hotelchar'];
        //dd($inputs);
        //$roomimages  = $inputs['room-images-'.(1)];
        ini_set("memory_limit","512M");
        //dd(imagecreatefromgd($roomimages[0]));
        /////////////////////////////
        $hotel = new $this->hotel;
        $hotel->title = $title;
        $hotel->homepage  = isset($inputs['homepage'])?'1':'0';
        $hotel->slug = khongdaurw($title);
        $hotel->images = $strimg;
        $hotel->description = $description;
        $hotel->address = $addess;
        $hotel->phone = $phone;
        $hotel->fax = $fax;
        $hotel->condition = $condition;
        $hotel->information = $information;
        $hotel->destinationpoint_id = $destinationpoint_id;
        $hotel->star = $star;
        $hotel->user_id = $user_id;
        $hotel->checkin = $checkin;
        $hotel->checkout = $checkout;
        $hotel->seokeyword = $seokeyword;
        $hotel->seodescription = $seodescription;
        $hotel->seotitle = $seotitle;
        $hotel->save();
        // makeing pivot table
        $hotel->hoteltypes()->attach($hoteltypes);
        $hotel->hotelcharacters()->attach($hotelchars);
        //new room objects
        for($i = 0 ;$i <count($roomtitles);$i++){
            $room = new Room();
            $room->title = $roomtitles[$i];
            $room->hotel_id = $hotel->id;
            $room->person = $persons[$i];
            $room->p_price = $p_prices[$i];
            $room->price = $prices[$i];
            $room->save();
            $roomimages = $inputs['room-images-'.($i+1)];
            $roomimagetitles  = $inputs['room-images-title-'.($i+1)];
            //////////// insert room images
            foreach($roomimages as $index=>$file)
            {
                if($file!=null) {
                    $count = $index + 1;
                    $filename = khongdaurw($inputs['title']) . '-' . khongdaurw($roomtitles[$i]) . '-hinh-' . $count . '.' . $file->getClientOriginalExtension();
                    $roomimage = new HotelImage();
                    $roomimage->image = $filename;
                    $roomimage->hotel_id = $hotel->id;
                    $roomimage->room_id = $room->id;
                    $roomimage->title = $roomimagetitles[$index];
                    $roomimage->save();
                    //check file exist step
                    $file->move('image', $filename);
                    waterMarkImage($filename);
                }
            }
        }
    }
    public function edit($id)
    {
        $hotel = $this->hotel->findOrFail($id);
        $selecthoteltype = HotelType::all();
        $selectdestinationpoint = DestinationPoint::orderBy('title')->pluck('title','id');
        $selectstaff = User::where('role_id','=',2)->pluck('fullname','id');
        return compact('selecthoteltype','selectdestinationpoint','selectstaff','hotel');
    }
    public function getHotelById($id){
        return  $this->hotel->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        //dd(Input::all());
        ////////////////////////////// list the input
        $title = $inputs['title'];
        $description = $inputs['description'];
        $addess = $inputs['address'];
        $phone = $inputs['phone'];
        $fax = $inputs['fax'];
        $condition = $inputs['condition'];
        $information = $inputs['information'];
        $destinationpoint_id = $inputs['destinationpoint_id'];
        $user_id = $inputs['user_id'];
        $star = $inputs['star'];
        $checkin = $inputs['checkin'];
        $checkout = $inputs['checkout'];
        if($inputs['seokeyword']!='') {
            $seokeyword = $inputs['seokeyword'];
        } else {
            $seokeyword = khongdau($title);
        }
        if($inputs['seodescription']!='') {
            $seodescription = $inputs['seodescription'];
        } else {
            $seodescription = khongdau(strip_tags($description));
        }
        if($inputs['seotitle']!='') {
            $seotitle = $inputs['seotitle'];
        } else {
            $seotitle = $title;
        }
        ////////////////arry field
        if(isset($inputs['roomtitle'])) {
            $roomtitles = $inputs['roomtitle'];
            $persons = $inputs['person'];
            $prices = $inputs['price'];
            $p_prices = $inputs['p_price'];
        }
        if(isset($inputs['hoteltype'])) {
            $hoteltypes = $inputs['hoteltype'];
            $hotelchars = $inputs['hotelchar'];
        }

        //dd($inputs);
        //$roomimages  = $inputs['room-images-'.(1)];
        ini_set("memory_limit","512M");
        //dd(imagecreatefromgd($roomimages[0]));
        /////////////////////////////
        $hotel = Hotel::find($id);
        $hotel->title = $title;
        $hotel->homepage  = isset($inputs['homepage'])?'1':'0';
        $hotel->slug = khongdaurw($title);
        $hotel->images = $strimg;
        $hotel->description = $description;
        $hotel->address = $addess;
        $hotel->phone = $phone;
        $hotel->fax = $fax;
        $hotel->condition = $condition;
        $hotel->information = $information;
        $hotel->destinationpoint_id = $destinationpoint_id;
        $hotel->star = $star;
        $hotel->user_id = $user_id;
        $hotel->checkin = $checkin;
        $hotel->checkout = $checkout;
        $hotel->seokeyword = $seokeyword;
        $hotel->seodescription = $seodescription;
        $hotel->seotitle = $seotitle;
        $hotel->save();
        // detach pivot table
        $hotel->hoteltypes()->detach();
        $hotel->hotelcharacters()->detach();
        // makeing pivot table
        if(isset($hoteltypes)) {
            $hotel->hoteltypes()->attach($hoteltypes);
            $hotel->hotelcharacters()->attach($hotelchars);
        }
        //edit old room objects
        $rooms = $hotel->rooms;
        foreach($rooms as $rm)
        {
            $oldtitle = $rm->title;
            $oldimages = $rm->images;
            $rm->title = $inputs['oldroomtitle'.$rm->id];
            $rm->person = $inputs['oldperson'.$rm->id];
            $rm->p_price = $inputs['oldprice'.$rm->id];
            $rm->price = $inputs['oldp_price'.$rm->id];
            $rm->save();
            ///// change name old image when tile change and change old image title

                foreach($oldimages as $index=>$oldimage){
                    if($oldtitle != $rm->title ) {
                        $arrstr = explode('.',$oldimage->image);
                        $ext = $arrstr[count($arrstr)-1];
                        $newfile = khongdaurw($hotel->title) . '-' . khongdaurw($rm->title) . '-hinh-' . ($index+1) . '.' . $ext;
                        if (File::exists(public_path() . '/image/' . $oldimage->image)) {
                            File::move(public_path() . '/image/' .  $oldimage->image, public_path() . '/image/' . $newfile);
                        }
                        $oldimage->image = $newfile;

                    }
                    $oldimage->title = $inputs['old-room-images-title-'.$oldimage->id];
                    $oldimage->save();
                }
            ///////////////
            $newroomimages = $inputs['new-room-images-'.$rm->id];
            $newroomimagetitles  = $inputs['new-room-images-title-'.$rm->id];
            //// add new image old room
            foreach($newroomimages as $index=>$file)
            {
                if($file!=null) {
                    $count = count($oldimages)+$index+ 1;
                    $filename = khongdaurw($inputs['title']) . '-' . khongdaurw($rm->title) . '-hinh-' . $count . '.' . $file->getClientOriginalExtension();
                    $roomimage = new HotelImage();
                    $roomimage->image = $filename;
                    $roomimage->hotel_id = $hotel->id;
                    $roomimage->room_id = $rm->id;
                    $roomimage->title = $newroomimagetitles[$index];
                    $roomimage->save();
                    //check file exist step
                    $file->move('image', $filename);
                    waterMarkImage($filename);
                }
            }
        }
        //new room objects
        if(isset($inputs['roomtitle'])) {
            for ($i = 0; $i < count($roomtitles); $i++) {
                if($roomtitles[$i]!='') {
                    $room = new Room();
                    $room->title = $roomtitles[$i];
                    $room->hotel_id = $hotel->id;
                    $room->person = $persons[$i];
                    $room->p_price = $p_prices[$i];
                    $room->price = $prices[$i];
                    $room->save();
                    $roomimages = $inputs['room-images-' . ($i + 1)];
                    $roomimagetitles = $inputs['room-images-title-' . ($i + 1)];
                    //////////// insert room images
                    foreach ($roomimages as $index => $file) {
                        $count = $index + 1;
                        $filename = khongdaurw($inputs['title']) . '-' . khongdaurw($roomtitles[$i]) . '-hinh-' . $count . '.' . $file->getClientOriginalExtension();
                        $roomimage = new HotelImage();
                        $roomimage->image = $filename;
                        $roomimage->hotel_id = $hotel->id;
                        $roomimage->room_id = $room->id;
                        $roomimage->title = $roomimagetitles[$i];
                        $roomimage->save();
                        //check file exist step
                        $file->move('image', $filename);
                        waterMarkImage($filename);
                    }
                }
            }
        }
    }
    public function destroy($id)
    {
        $hotel = $this->getHotelById($id);
        $strimages = $hotel->images;
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
        //thay doi hotel diem den ve mac dinh
        //$hotel->comments()->delete();

        $hotel->delete();
    }
    public function getSightPointByDestinationPoints($ids){
        return  $this->sightpoint->whereIn('destinationpoint_id',$ids)->orderBy('title')->get();
    }

}