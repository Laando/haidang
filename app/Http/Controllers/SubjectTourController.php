<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SubjectTourRepository;
use App\models\SubjectTour;
use Illuminate\Http\Request;
use App\Http\Requests\SubjectTourRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
class SubjectTourController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct(SubjectTourRepository $subjecttour_gestion)
    {
        $this->subjecttour_gestion = $subjecttour_gestion;
        $this->middleware('admin');
    }
	public function index()
	{
        // show users with 10 users per page
        $subjecttours = $this->subjecttour_gestion->index(10);

        $links = str_replace('/?', '?', $subjecttours->render());

        return view('back.subjecttour.index', compact('subjecttours', 'links'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('back.subjecttour.create', $this->subjecttour_gestion->create());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SubjectTourRequest $request)
	{
        $count = 1;
        $strimg = '';
        while(Input::hasFile('images-'.$count)){
            $file = Input::file('images-'.$count);
            $filename = khongdaurw($request['title']).'-hinh-'.$count.'.'.$file->getClientOriginalExtension();
            $strimg .= $filename . ';';
            $file->move('image',$filename);
            waterMarkImage($filename);
            $count++;
        }
        $fileicon = '';
        $fileicon_homepage = '';
        if(Input::hasFile('icon')){
            $file = Input::file('icon');
            $fileicon = khongdaurw($request['title']).'.'.$file->getClientOriginalExtension();
            $file->move('image/chude_icon',$fileicon);
        }
        if(Input::hasFile('icon_homepage')){
            $file = Input::file('icon_homepage');
            $fileicon_homepage = 'trang-chu'.khongdaurw($request['title']).'.'.$file->getClientOriginalExtension();
            $file->move('image/chude_icon',$fileicon_homepage);
        }
        $this->subjecttour_gestion->store($request->all(),$strimg , $fileicon , $fileicon_homepage );
        return redirect('subjecttour')->with('ok', trans('back/subjecttours.stored'));
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
        return view('back.subjecttour.edit',  $this->subjecttour_gestion->edit($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Requests\SubjectTourUpdateRequest $request,$id)
	{
        $subjecttour = $this->subjecttour_gestion->getSubjectTourById($id);
        $strimages = $subjecttour->images;
        if(trim($request['title'])!=trim($subjecttour->title)){

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
            $subjecttour->images = $strimages;

            $subjecttour->save();
        }
        //upload new images
        $strimg = $subjecttour->images;
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
        $fileicon = '';
        $fileicon_homepage = '';
        if(Input::hasFile('icon')){
            $file = Input::file('icon');
            $fileicon = khongdaurw($request['title']).'.'.$file->getClientOriginalExtension();
            $file->move('image/chude_icon',$fileicon);
        }
        if(Input::hasFile('icon_homepage')){
            $file = Input::file('icon_homepage');
            $fileicon_homepage = 'trang-chu'.khongdaurw($request['title']).'.'.$file->getClientOriginalExtension();
            $file->move('image/chude_icon',$fileicon_homepage);
        }
        $this->subjecttour_gestion->update($request->all(), $id , $strimg , $fileicon ,$fileicon_homepage);
        return redirect('subjecttour')->with('ok', trans('back/subjecttours.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $subjecttour = $this->subjecttour_gestion->getSubjectTourById($id);
        $strimages = $subjecttour->images;
        $oldarrimages = explode(';',trim($strimages,';'));
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        $flag = '0';
        foreach($oldarrimages as $in=>$val){
            if($val==$img){
                $flag = $in;
            }
        }
        $links = $subjecttour->imagelinks;
        $arrlinks = explode(';',trim($links,';'));
        unset($arrlinks[$flag]);
        $arrlinks = array_values($arrlinks);
        $subjecttour->imagelinks = implode(';',$arrlinks).';';
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($subjecttour->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $subjecttour->images = $strimages;
        $subjecttour->save();


        return 'ok';
    }
	public function destroy($id)
	{
        $this->subjecttour_gestion->destroy($id);
        return redirect('subjecttour')->with('ok', trans('back/subjecttours.destroyed'));
	}

}
