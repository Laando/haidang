<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\RegionRepository;
use App\Repositories\DestinationPointRepository;
use Illuminate\Http\Request;
use App\Http\Requests\DestinationPointRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\DestinationPointUpdateRequest;
use Illuminate\Support\Facades\File;
class DestinationPointController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(DestinationPointRepository $destinationpoint_gestion, RegionRepository $region_gestion)
    {
        $this->destinationpoint_gestion = $destinationpoint_gestion;
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
        $counts = $this->destinationpoint_gestion->counts();
        // show users with 10 users per page
        $destinationpoints = $this->destinationpoint_gestion->index(10, $regionid);

        $links = str_replace('/?', '?', $destinationpoints->render());
        $regions = $this->region_gestion->all();

        if($ajax)
        {
            return response()->json([
                'view' => view('back.destinationpoint.table', compact('destinationpoints', 'links', 'counts', 'regions'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }

        return view('back.destinationpoint.index', compact('destinationpoints', 'links', 'counts', 'regions'));
    }
    public function create()
    {
        return view('back.destinationpoint.create', $this->destinationpoint_gestion->create());
    }
    public function store(DestinationPointRequest $request)
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
        $this->destinationpoint_gestion->store($request->all(),$strimg );

        return redirect('destinationpoint')->with('ok', trans('back/destinationpoints.stored'));
    }
    public function edit($id)
    {
        return view('back.destinationpoint.edit',  $this->destinationpoint_gestion->edit($id));
    }
    public function update(DestinationPointUpdateRequest $request,$id)
    {
        $destinationpoint = $this->destinationpoint_gestion->getDestinationPointById($id);
        $strimages = $destinationpoint->images;
        if(trim($request['title'])!=trim($destinationpoint->title)){

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
            $destinationpoint->images = $strimages;

            $destinationpoint->save();
        }
        //upload new images
        $strimg = $destinationpoint->images;
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
        $this->destinationpoint_gestion->update($request->all(), $id , $strimg);
        return redirect('destinationpoint')->with('ok', trans('back/destinationpoints.updated'));
    }
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        $imagelink = $inputs['imagelink'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $destinationpoint = $this->destinationpoint_gestion->getDestinationPointById($id);
        $strimages = $destinationpoint->images;
        $destinationpoint->imagelinks = str_replace($imagelink.';','',$destinationpoint->imagelinks);
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($destinationpoint->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $destinationpoint->images = $strimages;
        $destinationpoint->save();


        return 'ok';
    }
    public function destroy($id)
    {
        $this->destinationpoint_gestion->destroy($id);

        return redirect('destinationpoint')->with('ok', trans('back/destinationpoints.destroyed'));
    }
}
