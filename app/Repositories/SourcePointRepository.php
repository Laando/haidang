<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 30/03/2015
 * Time: 11:10 AM
 */

namespace App\Repositories;


use App\Models\Region;
use App\Models\SourcePoint;
use Illuminate\Support\Facades\File;

class SourcePointRepository extends BaseRepository {
    protected $sourcepoint;
    protected $region;
    public function __construct(SourcePoint $sourcepoint , Region $region)
    {
        $this->sourcepoint = $sourcepoint;
        $this->region = $region;

    }
    public function index($n, $regionid)
    {
        if($regionid != 'total')
        {
            return $this->sourcepoint
                ->with('region')
                ->whereHas('region', function($q) use($regionid) {
                    $q->whereId($regionid);
                })
                ->latest()
                ->paginate($n);
        }

        return $this->sourcepoint
            ->with('region')
            ->latest()
            ->paginate($n);
    }
    public function count($regionid = null)
    {
        if($regionid)
        {
            return $this->sourcepoint
                ->whereHas('region', function($q) use($regionid) {
                    $q->where('id','like',$regionid);
                })->count();
        }

        return $this->model->count();
    }
    public function counts()
    {
        $counts = [
            '1' => $this->count('1'),
            '2' => $this->count('2'),
            '3' => $this->count('3'),
            '4' => $this->count('4'),
            '5' => $this->count('5'),
            '6' => $this->count('6'),
            '7' => $this->count('7'),
            '8' => $this->count('8')
        ];

        $counts['total'] = array_sum($counts);

        return $counts;
    }
    public function create()
    {
        $select = $this->region->all()->pluck('title', 'id');

        return compact('select');
    }
    public function store($inputs,$strimg)
    {
        $sourcepoint = new $this->sourcepoint;
        $sourcepoint->title  = $inputs['title'];
        $sourcepoint->description = $inputs['description'];
        $sourcepoint->content = $inputs['content'];
        $sourcepoint->priority = $inputs['priority'];
        $sourcepoint->images = $strimg;
        $sourcepoint->video = $inputs['video'];
        $sourcepoint->region_id = $inputs['region'];
        $sourcepoint->seokeyword = $inputs['seokeyword']==''?khongdau($inputs['title']):$inputs['seokeyword'];
        $sourcepoint->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $sourcepoint->seotitle = $inputs['seotitle']==''?khongdau($inputs['title']):$inputs['seotitle'];
        $sourcepoint->save();
    }
    public function edit($id)
    {
        $sourcepoint = $this->sourcepoint->findOrFail($id);
        $select = $this->region->all()->pluck('title', 'id');
        return compact('sourcepoint', 'select');
    }
    public function getSourcePointById($id){
        return  $this->sourcepoint->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        $sourcepoint = $this->getSourcePointById($id);
        $sourcepoint->title  = $inputs['title'];
        $sourcepoint->description = $inputs['description'];
        $sourcepoint->content = $inputs['content'];
        $sourcepoint->priority = $inputs['priority'];
        $sourcepoint->images = $strimg;
        $sourcepoint->video = $inputs['video'];
        $sourcepoint->region_id = $inputs['region'];
        $sourcepoint->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $sourcepoint->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $sourcepoint->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        $sourcepoint->save();
    }
    public function destroy($id)
    {
        $sourcepoint = $this->getSourcePointById($id);
        $strimages = $sourcepoint->images;
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
        //$sourcepoint->comments()->delete();

        $sourcepoint->delete();
    }
}