<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\DestinationPointRepository;
use App\Repositories\GiftRepository;
use Illuminate\Http\Request;
use App\Http\Requests\GiftRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\GiftUpdateRequest;
use Illuminate\Support\Facades\File;
class GiftController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct(GiftRepository $gift_gestion)
    {
        $this->gift_gestion = $gift_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        return $this->indexGo('total');
    }
    private function indexGo($destinationpointid, $ajax = false)
    {
        $gifts = $this->gift_gestion->index(10);
        $links = str_replace('/?', '?', $gifts->render());
        if($ajax)
        {
            return response()->json([
                'view' => view('back.gift.table', compact('gifts', 'links'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }
        return view('back.gift.index', compact('gifts', 'links'));
    }
    public function create()
    {
        return view('back.gift.create');
    }
    public function store(GiftRequest $request)
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
        $this->gift_gestion->store($request->all(),$strimg );

        return redirect('gift')->with('ok', trans('back/gifts.stored'));
    }
    public function edit($id)
    {
        return view('back.gift.edit',  $this->gift_gestion->edit($id));
    }
    public function update(GiftUpdateRequest $request,$id)
    {
        $strimages = '';
        $gift = $this->gift_gestion->getGiftById($id);
        if(trim($request['title'])!=trim($gift->title)){
            $strimages = $gift->images;
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
            $gift->images = $strimages;

            $gift->save();
        }
        //upload new images
        $strimg = $gift->images;
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
        $this->gift_gestion->update($request->all(), $id , $strimg);
        return redirect('gift')->with('ok', trans('back/gifts.updated'));
    }
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $gift = $this->gift_gestion->getGiftById($id);
        $strimages = $gift->images;
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($gift->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $gift->images = $strimages;
        $gift->save();


        return 'ok';
    }
    public function destroy($id)
    {
        $this->gift_gestion->destroy($id);

        return redirect('gift')->with('ok', trans('back/gifts.destroyed'));
    }
}
