<?php
namespace App\Repositories;


use App\Models\DestinationPoint;
use App\Models\Region;
use App\Models\Gift;
use Illuminate\Support\Facades\File;

class GiftRepository extends BaseRepository {
    protected $gift;
    protected $destinationpoint;
    public function __construct(Gift $gift , DestinationPoint $destinationpoint)
    {
        $this->gift = $gift;
        $this->destinationpoint = $destinationpoint;

    }
    public function index($n)
    {
        return $this->gift
            ->latest()
            ->paginate($n);
    }
    public function count()
    {
        return $this->destinationpoint->count();
    }
    public function counts()
    {

    }
    public function create()
    {
    }
    public function store($inputs,$strimg)
    {
        $gift = new $this->gift;
        $gift->title  = $inputs['title'];
        $gift->description = $inputs['description'];
        $gift->images = $strimg;
        $gift->point = $inputs['point'];
        $gift->status  = isset($inputs['status'])?'1':'0';
        $gift->save();
    }
    public function edit($id)
    {
        $gift = $this->gift->findOrFail($id);
        $select = $this->destinationpoint->all()->pluck('title', 'id');
        return compact('gift', 'select');
    }
    public function getGiftById($id){
        return  $this->gift->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        $gift = $this->getGiftById($id);
        $gift->title  = $inputs['title'];
        $gift->description = $inputs['description'];
        $gift->images = $strimg;
        $gift->point = $inputs['point'];
        $gift->status  = isset($inputs['status'])?'1':'0';
        $gift->save();
    }
    public function destroy($id)
    {
        $gift = $this->getGiftById($id);
        $strimages = $gift->images;
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
        //thay doi tour diem den ve mac dinh
        //$gift->comments()->delete();

        $gift->delete();
    }
}