<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\View;
use App\Repositories\TourRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\TourRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Requests\TourUpdateRequest;
class TourController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct(TourRepository $tour_gestion)
    {
        $this->tour_gestion = $tour_gestion;
        $this->middleware('staff');
        $user = Auth::user();
        View::share(compact('user'));
    }
	public function index(Request $request = null)
	{
        return $this->indexGo($request);
	}
    private function indexGo($request = null)
    {
        $userid = null;
        $subjecttourid = null;
        $search = null;
        $code = null;
        if($request!=null) {
            $userid = $request['user'];
            $subjecttourid = $request['subjecttour'];
            $search = $request['search'];
        }
        // show users with 10 users per page
        $tours = $this->tour_gestion->index(20, $userid,$subjecttourid,$search);
        //page pagigition
        $links = str_replace('/?', '?', $tours->render());
        //dd($tours->first()->user);

        $stafflist = $this->tour_gestion->user->where('role_id','=','2')->pluck('fullname','id')->all();
        $stafflist = array('' => 'Chọn quản lý') + $stafflist;
        $subjectlist = $this->tour_gestion->subjecttour->getNestedList('title',null,'--',true);
        $subjectlist = array('' => 'Chọn chủ đề') + $subjectlist;
        return view('back.tour.index', compact('tours', 'subjectlist', 'stafflist','links'));
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('back.tour.create', $this->tour_gestion->create());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TourRequest $request)
	{

        $v = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'traffic' => 'required|max:255',
            'period' => 'required|max:255',
            'subjecttours'=>'required',
        ]);
        $input = Input::all();
        $images =  $request->file('images');
        $rules = [];
        foreach($input['startdate'] as $key => $value) {
            $rules["startdate.$key"] = 'required';
        }
        $v->addRules($rules);
        if ($v->fails())
        {
//            /dd($v->errors());
            return redirect()->back()->withErrors($v->errors());
        }
        $strimg = '';
        if(count($images)>0){
            foreach ($images as $index=> $file){
                if($file->getClientOriginalExtension()!='') {
                    $filename = khongdaurw($request['title']).'-hinh-'.$index.'.'.$file->getClientOriginalExtension();
                    $strimg .= $filename . ';';
                    //check file exist step
                    $file->move('image',$filename);
                    //waterMarkImage($filename);
                }
            }
        }
        $this->tour_gestion->store($request->all(),$strimg );
        return redirect('tour')->with('ok', trans('back/subjecttours.stored'));
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
        return view('back.tour.edit',  $this->tour_gestion->edit($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TourUpdateRequest $request , $id)
	{
        $user  = Auth::user();
        $images =  $request->file('images');

       if(isset($request['Copy'])){
           $this->tour_gestion->copyTour($id,$request->all());
           return redirect('tour')->with('ok', trans('Copy tour mới thành công'));
       }
        $strimages='';
        $tour = $this->tour_gestion->getTourById($id, $user);
        if(trim($request['title'])!=trim($tour->title)){
            $strimages = $tour->images;
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
            $tour->images = $strimages;

            $tour->save();
        }

        //upload new images
        $strimg = $tour->images;
        $beginnumber = count(explode(';',$strimg));
        if(is_array($images)){
            foreach ($images as $index=> $file){
                if($file->getClientOriginalExtension()!='') {
                    $filename = khongdaurw($request['title']) . '-hinh-' . $beginnumber . '.' . $file->getClientOriginalExtension();
                    $file->move('image', $filename);
                    //waterMarkImage($filename);
                    if (strpos($strimg, $filename) === false) {
                        $strimg .= $filename . ';';
                    }
                    $beginnumber++;
                }
            }
        }
        if($strimg==''){$strimg = $strimages;}
        $this->tour_gestion->update($request->all(), $id , $strimg);
        return redirect('tour')->with('ok', trans('back/tours.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $user  = Auth::user();
        $tour = $this->tour_gestion->getTourById($id , $user);
        $strimages = $tour->images;
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::delete(public_path() . '/image/' . $images);
                    }
                    if (File::exists(public_path() . '/image/thumb_' . $images)) {
                        File::delete(public_path() . '/image/thumb_' . $images);
                    }
                }
            }
        }
        //thay doi tour diem den ve mac dinh
        $tour->reviews()->delete();
        foreach($tour->startdates as $sd){
            foreach($sd->orders as $od){
                $od->seats()->delete();
                $od->promotion_codes()->delete();
                $od->addings()->delete();
                $od->delete();
            }
            foreach($sd->transports as $tp){
                $tp->seats()->delete();
                $tp->delete();
            }
            $sd->addings()->delete();
            $sd->delete();
        }
        $tour->details()->delete();
        $tour->delete();
        return redirect()->intended('/tour');
	}
    public function getSightPointByDestinationPoint(){
        $inputs = Input::all();
        $arrid = $inputs['destinationpoints'];
        return json_encode($this->tour_gestion->getSightPointByDestinationPoints($arrid)->pluck('title','id')->all());
    }
    public function delImage($id)
    {
        $user  = Auth::user();
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $tour = $this->tour_gestion->getTourById($id , $user);
        $strimages = $tour->images;
        // check tour
        $last_char  = substr($strimages, -1);
        if($last_char!= ';') {
            $arrimages = explode(';',trim($strimages,';'));
            unset($arrimages[count($arrimages)-1]);
            $strimages = implode(';',$arrimages);
        }
        //
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);

                    if ($ext[1] != '') {
                        $newfile = khongdaurw($tour->title) . '-hinh-' . $count . '.' . $ext[1];
                        if (File::exists(public_path() . '/image/' . $images)) {
                            File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                        }
                        if (File::exists(public_path() . '/image/thumb_' . $images)) {
                            File::delete(public_path() . '/image/thumb_' . $images);
                        }
                        $strimages .= $newfile . ';';
                    }

                $count++;
            }
        }
        $tour->images = $strimages;
        $tour->save();
        return 'ok';
    }
}
