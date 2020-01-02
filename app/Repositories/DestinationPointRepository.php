<?php
namespace App\Repositories;


use App\Models\Region;
use App\Models\DestinationPoint;
use Illuminate\Support\Facades\File;

class DestinationPointRepository extends BaseRepository {
    protected $destinationpoint;
    protected $region;
    public function __construct(DestinationPoint $destinationpoint , Region $region)
    {
        $this->destinationpoint = $destinationpoint;
        $this->region = $region;

    }
    public function index($n, $regionid)
    {
        if($regionid != 'total')
        {
            return $this->destinationpoint
                ->with('region')
                ->whereHas('region', function($q) use($regionid) {
                    $q->whereId($regionid);
                })
                ->latest()
                ->paginate($n);
        }

        return $this->destinationpoint
            ->with('region')
            ->latest()
            ->paginate($n);
    }
    public function count($regionid = null)
    {
        if($regionid)
        {
            return $this->destinationpoint
                ->whereHas('region', function($q) use($regionid) {
                    $q->where('id','like',$regionid);
                })->count();
        }

        return $this->destinationpoint->count();
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
        $destinationpoint = new $this->destinationpoint;
        $destinationpoint->title  = $inputs['title'];
        $destinationpoint->isOutbound  = $inputs['isOutbound'];
        $destinationpoint->isHomepage  = isset($inputs['isHomepage'])?1:0;
        $destinationpoint->slug = khongdaurw($inputs['title']);
        $destinationpoint->description = $inputs['description'];
        $destinationpoint->content = $inputs['content'];
        $destinationpoint->priority = $inputs['priority'];
        $destinationpoint->images = $strimg;
        $destinationpoint->imagelinks = implode(';',$inputs['imagelinks']);
        $destinationpoint->video = $inputs['video'];
        $destinationpoint->region_id = $inputs['region'];
        $destinationpoint->seokeyword = $inputs['seokeyword']==''?khongdau($inputs['title']):$inputs['seokeyword'];
        $destinationpoint->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $destinationpoint->seotitle = $inputs['seotitle']==''?khongdau($inputs['title']):$inputs['seotitle'];
        $destinationpoint->save();
    }
    public function edit($id)
    {
        $destinationpoint = $this->destinationpoint->findOrFail($id);
        $select = $this->region->all()->pluck('title', 'id');
        return compact('destinationpoint', 'select');
    }
    public function getDestinationPointById($id){
        return  $this->destinationpoint->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        $destinationpoint = $this->getDestinationPointById($id);
        $destinationpoint->isOutbound  = $inputs['isOutbound'];
        $destinationpoint->isHomepage  = isset($inputs['isHomepage'])?1:0;
        $destinationpoint->title  = $inputs['title'];
        $destinationpoint->slug = khongdaurw($inputs['title']);
        $destinationpoint->description = $inputs['description'];
        $destinationpoint->content = $inputs['content'];
        $destinationpoint->priority = $inputs['priority'];
        $destinationpoint->images = $strimg;
        if(isset($inputs['imagelink'])) {
            $destinationpoint->imagelinks = implode(';', $inputs['imagelink']) . ';';
        }
        $destinationpoint->imagelinks .= implode(';',$inputs['imagelinknew']).';';
        $destinationpoint->video = $inputs['video'];
        $destinationpoint->region_id = $inputs['region'];
        $destinationpoint->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $destinationpoint->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $destinationpoint->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        $destinationpoint->save();
    }
    public function destroy($id)
    {
        $destinationpoint = $this->getDestinationPointById($id);
        $strimages = $destinationpoint->images;
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
        //$destinationpoint->comments()->delete();

        $destinationpoint->delete();
    }
    public function all()
    {
        return $this->destinationpoint->orderBy('priority','asc')->get();
    }

}