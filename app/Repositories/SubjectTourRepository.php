<?php
namespace App\Repositories;


use App\Models\SubjectTour;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class SubjectTourRepository extends BaseRepository {
    protected $subjecttour;
    public function __construct(SubjectTour $subjecttour)
    {
        $this->subjecttour = $subjecttour;
    }
    public function index($n)
    {
        return $this->subjecttour
            ->latest()
            ->paginate($n);
    }
    public function create()
    {
        $select = SubjectTour::getNestedList('title');
        $select = array('' => 'Root') + $select;

        return compact('select');
    }
    public function store($inputs,$strimg , $fileicon ,$fileicon_homepage )
    {
        $subjecttour = new $this->subjecttour;
        $subjecttour->title  = $inputs['title'];
        $subjecttour->slug = trim(khongdaurw($inputs['title']));
        $subjecttour->icon = $fileicon;
        $subjecttour->icon_homepage = $fileicon_homepage;
        $subjecttour->priority = $inputs['priority'];
        $subjecttour->homepage  = isset($inputs['homepage'])?'1':'0';
        $subjecttour->isOutbound  = $inputs['isOutbound'];
        $subjecttour->description = $inputs['description'];
        $subjecttour->content = $inputs['content'];
        $subjecttour->video = $inputs['video'];
        $subjecttour->images = $strimg;
        $subjecttour->imagelinks = implode(';',$inputs['imagelinks']);
        if(isset($inputs['parent'])) {
            $subjecttour->parent_id = $inputs['parent']==''?null:$inputs['parent'];
        }
        $subjecttour->save();
    }
    public function edit($id)
    {
        $select = SubjectTour::getNestedList('title');
        $select = array('' => 'Root') + $select;
        $subjecttour = $this->subjecttour->findOrFail($id);

        return compact('subjecttour', 'select');
    }
    public function getSubjectTourById($id){
        return  $this->subjecttour->findOrFail($id);
    }
    public function update($inputs, $id ,$strimg,$fileicon ,$fileicon_homepage)
    {
        $subjecttour = $this->getSubjectTourById($id);
        $subjecttour->title  = $inputs['title'];
        $subjecttour->description = $inputs['description'];
        $subjecttour->content = $inputs['content'];
        $subjecttour->video = $inputs['video'];
        $subjecttour->slug = $inputs['slug'];
        if($fileicon!='')  $subjecttour->icon = $fileicon;
        if($fileicon_homepage!='')  $subjecttour->icon_homepage = $fileicon_homepage;
        $subjecttour->priority = $inputs['priority'];
        $subjecttour->images = $strimg;
        if(isset($inputs['imagelink'])) {
            $subjecttour->imagelinks = implode(';', $inputs['imagelink']) . ';';
        }
        $subjecttour->imagelinks .= implode(';',$inputs['imagelinknew']).';';
        $subjecttour->homepage  = isset($inputs['homepage'])?'1':'0';
        $subjecttour->isOutbound  = $inputs['isOutbound'];
        $subjecttour->parent_id = $inputs['parent']==''?null:$inputs['parent'];
        $subjecttour->save();
    }
    public function destroy($id)
    {
        $subjecttour = $this->getSubjectTourById($id);
        $subjecttour->delete();
    }
    public function all()
    {
        return $this->subjecttour->orderBy('priority','asc')->get();
    }

}