<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\RegionRepository;
use App\Repositories\SourcePointRepository;
use Illuminate\Http\Request;
use App\Http\Requests\SourcePointRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\SourcePointUpdateRequest;
use Illuminate\Support\Facades\File;
class SourcePointController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function __construct(SourcePointRepository $sourcepoint_gestion, RegionRepository $region_gestion)
    {
        $this->sourcepoint_gestion = $sourcepoint_gestion;
        $this->region_gestion = $region_gestion;
        $this->middleware('admin');
    }
	public function index()
	{
        return $this->indexGo('total');
	}

    public function indexSort($regionid)
    {
        return $this->indexGo($regionid, true);
    }
    private function indexGo($regionid, $ajax = false)
    {
        $counts = $this->sourcepoint_gestion->counts();
        // show users with 10 users per page
        $sourcepoints = $this->sourcepoint_gestion->index(10, $regionid);

        $links = str_replace('/?', '?', $sourcepoints->render());
        $regions = $this->region_gestion->all();

        if($ajax)
        {
            return response()->json([
                'view' => view('back.sourcepoint.table', compact('sourcepoints', 'links', 'counts', 'regions'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }

        return view('back.sourcepoint.index', compact('sourcepoints', 'links', 'counts', 'regions'));
    }
    public function create()
    {
        return view('back.sourcepoint.create', $this->sourcepoint_gestion->create());
    }
    public function store(SourcePointRequest $request)
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
        $this->sourcepoint_gestion->store($request->all(),$strimg );

        return redirect('sourcepoint')->with('ok', trans('back/sourcepoints.stored'));
    }
    public function edit($id)
    {
        return view('back.sourcepoint.edit',  $this->sourcepoint_gestion->edit($id));
    }
    public function update(SourcePointUpdateRequest $request,$id)
    {
        $sourcepoint = $this->sourcepoint_gestion->getSourcePointById($id);
        if(trim($request['title'])!=trim($sourcepoint->title)){
            $strimages = $sourcepoint->images;
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
            $sourcepoint->images = $strimages;

            $sourcepoint->save();
        }
        //upload new images
        $strimg = $sourcepoint->images;
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
        $this->sourcepoint_gestion->update($request->all(), $id , $strimg);
        return redirect('sourcepoint')->with('ok', trans('back/sourcepoints.updated'));
    }
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $sourcepoint = $this->sourcepoint_gestion->getSourcePointById($id);
        $strimages = $sourcepoint->images;
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($sourcepoint->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $sourcepoint->images = $strimages;
        $sourcepoint->save();


        return 'ok';
    }
    public function destroy($id)
    {
        $this->sourcepoint_gestion->destroy($id);

        return redirect('sourcepoint')->with('ok', trans('back/sourcepoints.destroyed'));
    }
}
