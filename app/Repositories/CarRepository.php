<?php
namespace App\Repositories;


use App\Models\DestinationPoint;
use App\Models\Region;
use App\Models\Car;
use Illuminate\Support\Facades\File;

class CarRepository extends BaseRepository {
    protected $car;
    protected $destinationpoint;
    public function __construct(Car $car , DestinationPoint $destinationpoint)
    {
        $this->car = $car;
        $this->destinationpoint = $destinationpoint;

    }
    public function index($n)
    {
        return $this->car
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
        $car = new $this->car;
        $car->title  = $inputs['title'];
        $car->slug  = khongdaurw($inputs['title']);
        $car->supportphone = $inputs['supportphone'];
        $car->description = $inputs['description'];
        $car->detailprice = $inputs['detailprice'];
        $car->routeprice = $inputs['routeprice'];
        $car->notice = $inputs['notice'];
        $car->warning = $inputs['warning'];
        $car->images = $strimg;
        $car->save();
    }
    public function edit($id)
    {
        $car = $this->car->findOrFail($id);
        $select = $this->destinationpoint->all()->pluck('title', 'id');
        return compact('car', 'select');
    }
    public function getCarById($id){
        return  $this->car->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        $car = $this->getCarById($id);
        $car->title  = $inputs['title'];
        $car->slug  = khongdaurw($inputs['title']);
        $car->supportphone = $inputs['supportphone'];
        $car->description = $inputs['description'];
        $car->detailprice = $inputs['detailprice'];
        $car->routeprice = $inputs['routeprice'];
        $car->notice = $inputs['notice'];
        $car->warning = $inputs['warning'];
        $car->images = $strimg;
        $car->save();
    }
    public function destroy($id)
    {
        $car = $this->getCarById($id);
        $strimages = $car->images;
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
        //$car->comments()->delete();

        $car->delete();
    }
}