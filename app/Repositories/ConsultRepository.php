<?php
namespace App\Repositories;


use App\Models\Banner;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ConsultRepository extends BaseRepository {
    public $consult;
    public function __construct(        Contact $consult )
    {
        $this->consult = $consult;
    }
    public function index($n)
    {
        $consults = $this->consult;
        $user  = auth()->user();
        if($user->isAdmin()){
            return $consults->orderBy('is_check','ASC')->latest()->paginate($n);
        } else {
            return $consults->whereHas('tour',function($q)use($user){
                    $q->where('user_id',$user->id);
            })->orderBy('is_check','ASC')->latest()->paginate($n);
        }


    }
    public function count($type = null)
    {
        if($type)
        {
            return $this->consult
                ->where('type','like',$type)
                ->count();
        }

        return $this->consult->count();
    }
    public function counts()
    {
        $consults = $this->consult->groupBy('type')->get();
        $counts = array();
        foreach ($consults as $consult) {
            $counts[ $consult->type ] = $this->count($consult->type);
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
        //create consult object
        $consult = new $this->consult;
        $consult->title = $inputs['title'];
        $consult->url = $inputs['url'];
        $consult->alt = $inputs['alt'];
        $consult->priority = $inputs['priority'];
        $consult->type = $inputs['type'];
        $consult->images = $strimg;
        $consult->save();
    }
    public function edit($id)
    {
        $consult = $this->consult->findOrFail($id);
        $typelist = $this->makeTypeList();
        return compact('typelist','consult');
    }
    public function getTourById($id){
        return  $this->tour->findOrFail($id);
    }
    public function update($inputs, $id , $strimg)
    {
        $consult = $this->consult->findOrFail($id);
        $consult->title = $inputs['title'];
        $consult->url = $inputs['url'];
        $consult->alt = $inputs['alt'];
        $consult->priority = $inputs['priority'];
        $consult->type = $inputs['type'];
        $consult->images = $strimg;
        $consult->save();
    }
    public function destroy($id)
    {
        $consult = $this->consult->findOrFail($id);
        $strimages = $consult->images;
        if($strimages!='') {
                $ext = explode('.', $strimages);
                if ($ext[1] != '') {
                    if (File::exists(public_path() . '/image/' . $strimages)) {
                        File::delete(public_path() . '/image/' . $strimages);
                    }
                }
        }
        $consult->delete();
    }
}