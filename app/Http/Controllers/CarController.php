<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\DestinationPointRepository;
use App\Repositories\CarRepository;
use Illuminate\Http\Request;
use App\Http\Requests\CarRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CarUpdateRequest;
use Illuminate\Support\Facades\File;
class CarController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(CarRepository $car_gestion)
    {
        $this->car_gestion = $car_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        return $this->indexGo('total');
    }
    private function indexGo($destinationpointid, $ajax = false)
    {
        $cars = $this->car_gestion->index(10);
        $links = str_replace('/?', '?', $cars->render());
        if($ajax)
        {
            return response()->json([
                'view' => view('back.car.table', compact('cars', 'links'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }
        return view('back.car.index', compact('cars', 'links'));
    }
    public function create()
    {
        return view('back.car.create');
    }
    public function store(CarRequest $request)
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
        $this->car_gestion->store($request->all(),$strimg );

        return redirect('car')->with('ok', trans('back/cars.stored'));
    }
    public function edit($id)
    {
        return view('back.car.edit',  $this->car_gestion->edit($id));
    }
    public function update(CarUpdateRequest $request,$id)
    {
        $strimages = '';
        $car = $this->car_gestion->getCarById($id);
        if(trim($request['title'])!=trim($car->title)){
            $strimages = $car->images;
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
            $car->images = $strimages;

            $car->save();
        }
        //upload new images
        $strimg = $car->images;
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
        $this->car_gestion->update($request->all(), $id , $strimg);
        return redirect('car')->with('ok', trans('back/cars.updated'));
    }
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $car = $this->car_gestion->getCarById($id);
        $strimages = $car->images;
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($car->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $car->images = $strimages;
        $car->save();


        return 'ok';
    }
    public function destroy($id)
    {
        $this->car_gestion->destroy($id);

        return redirect('car')->with('ok', trans('back/cars.destroyed'));
    }
}
