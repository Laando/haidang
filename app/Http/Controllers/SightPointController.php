<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\DestinationPointRepository;
use App\Repositories\SightPointRepository;
use Illuminate\Http\Request;
use App\Http\Requests\SightPointRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\SightPointUpdateRequest;
use Illuminate\Support\Facades\File;
class SightPointController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(SightPointRepository $sightpoint_gestion, DestinationPointRepository $destinationpoint_gestion)
    {
        $this->sightpoint_gestion = $sightpoint_gestion;
        $this->destinationpoint_gestion = $destinationpoint_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        return $this->indexGo('total');
    }

    public function indexSort($destinationpointid)
    {
        return $this->indexGo($destinationpointid, true);
    }
    private function indexGo($destinationpointid, $ajax = false)
    {
        $counts = $this->sightpoint_gestion->counts();
        // show users with 10 users per page
        $sightpoints = $this->sightpoint_gestion->index(10, $destinationpointid);

        $links = str_replace('/?', '?', $sightpoints->render());
        $destinationpoints = $this->destinationpoint_gestion->all();

        if($ajax)
        {
            return response()->json([
                'view' => view('back.sightpoint.table', compact('sightpoints', 'links', 'counts', 'destinationpoints'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }

        return view('back.sightpoint.index', compact('sightpoints', 'links', 'counts', 'destinationpoints'));
    }
    public function create()
    {
        return view('back.sightpoint.create', $this->sightpoint_gestion->create());
    }
    public function store(SightPointRequest $request)
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
        $this->sightpoint_gestion->store($request->all(),$strimg );

        return redirect('sightpoint')->with('ok', trans('back/sightpoints.stored'));
    }
    public function edit($id)
    {
        return view('back.sightpoint.edit',  $this->sightpoint_gestion->edit($id));
    }
    public function update(SightPointUpdateRequest $request,$id)
    {
        $strimages = '';
        $sightpoint = $this->sightpoint_gestion->getSightPointById($id);
        if(trim($request['title'])!=trim($sightpoint->title)){
            $strimages = $sightpoint->images;
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
            $sightpoint->images = $strimages;

            $sightpoint->save();
        }
        //upload new images
        $strimg = $sightpoint->images;
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
        $this->sightpoint_gestion->update($request->all(), $id , $strimg);
        return redirect('sightpoint')->with('ok', trans('back/sightpoints.updated'));
    }
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $sightpoint = $this->sightpoint_gestion->getSightPointById($id);
        $strimages = $sightpoint->images;
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($sightpoint->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $sightpoint->images = $strimages;
        $sightpoint->save();


        return 'ok';
    }
    public function destroy($id)
    {
        $this->sightpoint_gestion->destroy($id);

        return redirect('sightpoint')->with('ok', trans('back/sightpoints.destroyed'));
    }
}
