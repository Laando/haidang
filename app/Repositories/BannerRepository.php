<?php
namespace App\Repositories;


use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class BannerRepository extends BaseRepository {
    public $banner;
    public function __construct(        Banner $banner )
    {
        $this->banner = $banner;
    }
    public function index($n, $type)
    {
        $banners = $this->banner;
        if ($type!='total')
        {
            $banners = $banners->where('type','like','%'.$type.'%');
        }
        return $banners->latest()->paginate($n);

    }
    public function count($type = null)
    {
        if($type)
        {
            return $this->banner
                ->where('type','like',$type)
                ->count();
        }

        return $this->banner->count();
    }
    public function counts()
    {
        $banners = $this->banner->groupBy('type')->get();
        $counts = array();
        foreach ($banners as $banner) {
            $counts[ $banner->type ] = $this->count($banner->type);
        }
        $counts['total'] = array_sum($counts);

        return $counts;
    }
    public function create()
    {
        $typelist = $this->makeTypeList();
        return compact('typelist');
    }
    public function store($inputs,$strimg)
    {
        //create banner object
        $banner = new $this->banner;
        $banner->title = $inputs['title'];
        $banner->url = $inputs['url'];
        $banner->alt = $inputs['alt'];
        $banner->priority = $inputs['priority'];
        $banner->type = $inputs['type'];
        $banner->images = $strimg;
        $banner->save();
    }
    public function edit($id)
    {
        $banner = $this->banner->findOrFail($id);
        $typelist = $this->makeTypeList();
        return compact('typelist','banner');
    }
    public function getTourById($id){
        return  $this->tour->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        $banner = $this->banner->findOrFail($id);
        $banner->title = $inputs['title'];
        $banner->url = $inputs['url'];
        $banner->alt = $inputs['alt'];
        $banner->priority = $inputs['priority'];
        $banner->type = $inputs['type'];
        $banner->images = $strimg;
        $banner->save();
    }
    public function destroy($id)
    {
        $banner = $this->banner->findOrFail($id);
        $strimages = $banner->images;
        if($strimages!='') {
                $ext = explode('.', $strimages);
                if ($ext[1] != '') {
                    if (File::exists(public_path() . '/image/' . $strimages)) {
                        File::delete(public_path() . '/image/' . $strimages);
                    }
                }
        }
        $banner->delete();
    }
    public function makeTypeList()
    {
         return $typelist = [
            'homepage-slide'=>'Banner slide trang chủ',
            'homepage-top'=>'Top Banner HomePage',
            'homepage-subject'=>'Subject Banner HomePage',
            'homepage-destination'=>'Destination Banner HomePage',
            'homepage-doan'=>'Group Banner HomePage',
             'tour-domestic-banner'=>'Banner slide trong nước',
             'tour-outbound-banner'=>'Banner slide nươc ngoài',
             'tour-group-banner'=>'Banner slide tour đoàn',
            'homepage-bottom-banner'=>'Banner cuối trang chủ',
            'user-banner'=>'Banner trang User Home',
            'usergift_banner'=>'Banner trang User Home Gift',
            'price-top-banner' => '1 banner-top Price Sheet',
             'footer-demo' => '4 Demo Footer',
             'demo-home-blog'=>'Demo Home Blog',
             'demo-home-spec-blog'=>'Demo Home Event Blog',
        ];

    }
}