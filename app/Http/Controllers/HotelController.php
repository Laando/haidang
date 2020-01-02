<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\HotelImage;
use App\Repositories\HotelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\HotelRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Requests\HotelUpdateRequest;
class HotelController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct(HotelRepository $hotel_gestion)
    {
        $this->hotel_gestion = $hotel_gestion;
        $this->middleware('admin');
    }
	public function index(Request $request = null)
	{
        return $this->indexGo($request);
	}
    private function indexGo($request = null)
    {
        $hotels = $this->hotel_gestion->index(20);
        //page pagigition
        $links = str_replace('/?', '?', $hotels->render());
        //dd($hotels->first()->user);
        return view('back.hotel.index', compact('hotels','links'));
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('back.hotel.create', $this->hotel_gestion->create());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{

        $v = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'hoteltype' =>'required',
            'star' => 'required|numeric',
            'checkin' => 'numeric',
            'checkout' => 'numeric'
        ]);
        if ($v->fails())
        {
            //$request->flash();
            return redirect()->back()->withErrors($v->errors());
        }
        $count = 1;
        $strimg = '';
        while(Input::hasFile('images-'.$count)){
            $file = Input::file('images-'.$count);
            $filename = khongdaurw($request['title']).'-hinh-'.$count.'.'.$file->getClientOriginalExtension();
            $strimg .= $filename . ';';
            //check file exist step
            $file->move('image',$filename);
            waterMarkImage($filename);
            $count++;
        }
        $this->hotel_gestion->store($request->all(),$strimg );
        return redirect('hotel')->with('ok', trans('back/subjecthotels.stored'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return view('back.hotel.edit',  $this->hotel_gestion->edit($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request , $id)
	{
        $v = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'hoteltype' =>'required',
            'star' => 'required|numeric',
            'checkin' => 'numeric',
            'checkout' => 'numeric'
        ]);
        if ($v->fails())
        {
            $request->flash();
            return redirect()->back()->withOldInput()->withErrors($v->errors());
        }
        $strimages='';
        $hotel = $this->hotel_gestion->getHotelById($id);
        if(trim($request['title'])!=trim($hotel->title)){
            $strimages = $hotel->images;
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
            $hotel->images = $strimages;

            $hotel->save();
        }

        //upload new images
        $strimg = $hotel->images;
        $beginnumber = count(explode(';',$strimg));
        $countt = 1;
        while(Input::hasFile('images-'.$countt)){
            $count = 1;
            $file = Input::file('images-'.$countt);
            if($file!=null) {
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
        $this->hotel_gestion->update($request->all(), $id , $strimg);
        return redirect('hotel')->with('ok', trans('back/hotels.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $hotel = $this->hotel_gestion->getHotelById($id);
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
        return redirect()->intended('/hotel');
	}
    public function getSightPointByDestinationPoint(){
        $inputs = Input::all();
        $arrid = $inputs['destinationpoints'];
        return json_encode($this->hotel_gestion->getSightPointByDestinationPoints($arrid)pluck('title','id')->all());
    }
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $hotel = $this->hotel_gestion->getHotelById($id);
        $strimages = $hotel->images;
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($hotel->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $hotel->images = $strimages;
        $hotel->save();
        return 'ok';
    }
    public function delHotelImage()
    {
        $inputs = Input::all();
        $image = HotelImage::find($inputs['img']);
        if(File::exists(public_path().'\image\\'.$image->image))
        {
            File::delete(public_path().'\image\\'.$image->image);
        }
        $image->delete();
        return 'ok';
    }
}
