<?php
namespace App\Repositories;


use App\Models\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ConfigRepository extends BaseRepository {
    public $config;
    public function __construct(        Config $config )
    {
        $this->config = $config;
    }
    public function index($n, $type)
    {
        $configs = $this->config;
        if ($type!='total')
        {
            $configs = $configs->where('type','like','%'.$type.'%');
        }
        return $configs->latest()->paginate($n);

    }
    public function count($type = null)
    {
        if($type)
        {
            return $this->config
                ->where('type','like',$type)
                ->count();
        }

        return $this->config->count();
    }
    public function counts()
    {
        $configs = $this->config->groupBy('type')->get();
        $counts = array();
        foreach ($configs as $config) {
            $counts[ $config->type ] = $this->count($config->type);
        }
        $counts['total'] = array_sum($counts);

        return $counts;
    }
    public function create()
    {
        $typelist = $this->makeTypeList();
        return compact('typelist');
    }
    public function store($inputs)
    {
        //create config object
        $config = new $this->config;
        $config->title = $inputs['title'];
        $config->content = $inputs['content'];
        $config->type = $inputs['type'];
        $config->is_page  = isset($inputs['is_page'])?1:0;
        $config->save();
    }
    public function edit($id)
    {
        $config = $this->config->findOrFail($id);
        return compact('config');
    }
    public function getTourById($id){
        return  $this->tour->findOrFail($id);
    }
    public function update($inputs, $id)
    {
        $config = $this->config->findOrFail($id);
        $config->title = $inputs['title'];
        $config->content = $inputs['content'];
        $config->type = $inputs['type'];
        $config->is_page  = isset($inputs['is_page'])?1:0;
        $config->save();
    }
    public function destroy($id)
    {
        $config = $this->config->findOrFail($id);
        $config->delete();
    }
    public function makeTypeList()
    {
         return $typelist = [
            'homepage-slide'=>'Slide HomePage',
            'homepage-bottom-config'=>'3 config-bottom HomePage',
            'tour-top-config'=>'1 config-top Tour',
            'tour-bottom-config'=>'3 config-bottom Tour',
            'transport-config'=>'1 config Transport',
            'transport-cate-config'=>'1 config Transport Category'
        ];

    }
}