<?php
namespace App\Repositories;


use App\Models\DestinationPoint;
use App\Models\Region;
use App\Models\SightPoint;
use Illuminate\Support\Facades\File;

class SightPointRepository extends BaseRepository {
    protected $sightpoint;
    protected $destinationpoint;
    public function __construct(SightPoint $sightpoint , DestinationPoint $destinationpoint)
    {
        $this->sightpoint = $sightpoint;
        $this->destinationpoint = $destinationpoint;

    }
    public function index($n, $destinationpointid)
    {
        if($destinationpointid != 'total')
        {
            return $this->sightpoint
                ->with('destinationpoint')
                ->whereHas('destinationpoint', function($q) use($destinationpointid) {
                    $q->whereId($destinationpointid);
                })
                ->latest()
                ->paginate($n);
        }

        return $this->sightpoint
            ->with('destinationpoint')
            ->latest()
            ->paginate($n);
    }
    public function count($destinationpointid = null)
    {
        if($destinationpointid)
        {
            return $this->sightpoint
                ->whereHas('destinationpoint', function($q) use($destinationpointid) {
                    $q->where('id','like',$destinationpointid);
                })->count();
        }

        return $this->destinationpoint->count();
    }
    public function counts()
    {
        $destinationpoints = $this->destinationpoint->all();
        $counts = array();
        foreach ($destinationpoints as $destinationpoint) {
            $counts[ $destinationpoint->id ] = $this->count($destinationpoint->id);
        }
        $counts['total'] = array_sum($counts);

        return $counts;
    }
    public function create()
    {
        $select = $this->destinationpoint->all()->pluck('title', 'id');

        return compact('select');
    }
    public function store($inputs,$strimg)
    {
        $sightpoint = new $this->sightpoint;
        $sightpoint->title  = $inputs['title'];
        $sightpoint->slug = khongdaurw($inputs['title']);
        $sightpoint->description = $inputs['description'];
        $sightpoint->content = $inputs['content'];
        $sightpoint->price = $inputs['price'];
        $sightpoint->images = $strimg;
        $sightpoint->video = $inputs['video'];
        $sightpoint->destinationpoint_id = $inputs['destinationpoint'];
        $sightpoint->seokeyword = $inputs['seokeyword']==''?khongdau($inputs['title']):$inputs['seokeyword'];
        $sightpoint->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $sightpoint->seotitle = $inputs['seotitle']==''?khongdau($inputs['title']):$inputs['seotitle'];
        $sightpoint->save();
    }
    public function edit($id)
    {
        $sightpoint = $this->sightpoint->findOrFail($id);
        $select = $this->destinationpoint->all()->pluck('title', 'id');
        return compact('sightpoint', 'select');
    }
    public function getSightPointById($id){
        return  $this->sightpoint->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        $sightpoint = $this->getSightPointById($id);
        $sightpoint->title  = $inputs['title'];
        $sightpoint->slug = khongdaurw($inputs['title']);
        $sightpoint->description = $inputs['description'];
        $sightpoint->content = $inputs['content'];
        $sightpoint->price = $inputs['price'];
        $sightpoint->images = $strimg;
        $sightpoint->video = $inputs['video'];
        $sightpoint->destinationpoint_id = $inputs['destinationpoint'];
        $sightpoint->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $sightpoint->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $sightpoint->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        $sightpoint->touch();
        $sightpoint->save();
    }
    public function destroy($id)
    {
        $sightpoint = $this->getSightPointById($id);
        $strimages = $sightpoint->images;
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
        //$sightpoint->comments()->delete();

        $sightpoint->delete();
    }
}