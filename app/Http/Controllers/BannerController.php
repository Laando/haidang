<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use App\Http\Requests\BannerRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\BannerUpdateRequest;
use Illuminate\Support\Facades\File;
class BannerController extends Controller {

    public function __construct(BannerRepository $banner_gestion )
    {
        $this->banner_gestion = $banner_gestion;
        $this->middleware('admin');
    }
	public function index()
	{
        return $this->indexGo('total');
	}
    public function indexSort($type)
    {
        return $this->indexGo($type, true);
    }
    private function indexGo($type, $ajax = false)
    {
        $counts = $this->banner_gestion->counts();
        // show users with 10 users per page
        $banners = $this->banner_gestion->index(20, $type);
        $links = str_replace('/?', '?', $banners->render());
        //types = $this->banner_gestion->banner->groupBy('type')->pluck('type');
        $types = $this->banner_gestion->makeTypeList();
        if($ajax)
        {
            return response()->json([
                'view' => view('back.banner.table', compact('banners', 'links', 'counts','types'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }

        return view('back.banner.index', compact('banners', 'links', 'counts','types'));
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('back.banner.create', $this->banner_gestion->create());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(BannerRequest $request)
	{
        $count = 1;
        $strimg = '';
        $file = Input::file('images-'.$count);
        $filename = khongdaurw($request['title']).'-hinh-'.$count.'.'.$file->getClientOriginalExtension();
        $strimg .= $filename;
        $file->move('image',$filename);
        //waterMarkImage($filename);
        $this->banner_gestion->store($request->all(),$strimg );
        return redirect('banner')->with('ok', trans('back/banners.stored'));
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
        return view('back.banner.edit',  $this->banner_gestion->edit($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(BannerUpdateRequest $request ,$id)
	{
        $banner = $this->banner_gestion->banner->findOrFail($id);
        $strimages = $banner->images;
        //dd($banner);
        if(trim($request['title'])!=trim($banner->title)){
            if($strimages!='') {
                $count = 1;
                    $ext = explode('.', $strimages);
                    if ($ext[1] != '') {
                        $newfile = khongdaurw($request['title']) . '-hinh-' . $count . '.' . $ext[1];
                        if (File::exists(public_path() . '/image/' . $strimages)) {
                            File::move(public_path() . '/image/' . $strimages, public_path() . '/image/' . $newfile);
                        }
                        $strimages = $newfile ;
                    }
            }
            $banner->images = $strimages;
            $banner->save();
        }
        //upload new images
        $strimg = '';
        $countt = 1;
        if(Input::hasFile('images-' . $countt)) {
            $file = Input::file('images-' . $countt);
            if ($file->getClientOriginalExtension() != '') {
                $filename = khongdaurw($request['title']) . '-hinh-' . $countt . '.' . $file->getClientOriginalExtension();
                $file->move('image', $filename);
                //if($request['type']!='homepage-slide')  waterMarkImage($filename);
                $strimg = $filename;
            }
        }
        if($strimg==''){$strimg = $strimages;}
        $this->banner_gestion->update($request->all(), $id , $strimg);
        return redirect('banner')->with('ok', trans('back/banners.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

        if(is_numeric($id))
        {
            $startdate = Banner::findOrFail($id);
            $startdate->delete();
            return redirect('banner')->with('ok', trans('back/banners.destroy'));
        }
	}

}
