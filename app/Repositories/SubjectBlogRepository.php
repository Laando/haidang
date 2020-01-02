<?php
namespace App\Repositories;


use App\Models\SubjectBlog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class SubjectBlogRepository extends BaseRepository {
    protected $subjectblog;
    public function __construct(SubjectBlog $subjectblog)
    {
        $this->subjectblog = $subjectblog;
    }
    public function index($n)
    {
        return $this->subjectblog
            ->latest()
            ->paginate($n);
    }
    public function create()
    {
        $select = SubjectBlog::getNestedList('title');
        $select = array('' => 'Root') + $select;

        return compact('select');
    }
    public function store($inputs)
    {
        $subjectblog = new $this->subjectblog;
        $subjectblog->title  = $inputs['title'];
        $subjectblog->slug = trim(khongdaurw($inputs['title']));
        $subjectblog->priority = $inputs['priority'];
        $subjectblog->description = $inputs['description'];
        if(isset($inputs['parent'])) {
            $subjectblog->parent_id = $inputs['parent']==''?null:$inputs['parent'];
        }
        $subjectblog->save();
    }
    public function edit($id)
    {
        $select = SubjectBlog::getNestedList('title');
        $select = array('' => 'Root') + $select;
        $subjectblog = $this->subjectblog->findOrFail($id);

        return compact('subjectblog', 'select');
    }
    public function getSubjectBlogById($id){
        return  $this->subjectblog->findOrFail($id);
    }
    public function update($inputs, $id)
    {
        $subjectblog = $this->getSubjectBlogById($id);
        $subjectblog->title  = $inputs['title'];
        $subjectblog->description = $inputs['description'];
        $subjectblog->slug = trim(khongdaurw($inputs['title']));
        $subjectblog->priority = $inputs['priority'];
        $subjectblog->parent_id = $inputs['parent']==''?null:$inputs['parent'];
        $subjectblog->save();
    }
    public function destroy($id)
    {
        $subjectblog = $this->getSubjectBlogById($id);
        $subjectblog->delete();
    }
    public function all()
    {
        return $this->subjectblog->orderBy('priority','asc')->get();
    }

}