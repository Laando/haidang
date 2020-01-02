<?php
namespace App\Repositories;


use App\Models\DestinationPoint;
use App\models\Detail;
use App\Models\SightPoint;
use App\Models\SourcePoint;
use App\models\StartDate;
use App\Models\SubjectBlog;
use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class BlogRepository extends BaseRepository {
    protected $sightpoint;
    protected $destinationpoint;
    protected $blog;
    public $user;
    protected $detail;
    protected $sourcepoint;
    protected $startdate;
    public $subjectblog;
    public function __construct(
        Blog $blog ,
        DestinationPoint $destinationpoint ,
        SubjectBlog $subjectblog
    )
    {
        $this->blog = $blog;
        $this->destinationpoint = $destinationpoint;
        $this->subjectblog = $subjectblog;
    }
    public function index($n, $destinationpointid,$subjectblogid,$search)
    {
        $blogs = $this->blog;
        if ($subjectblogid!='')
        {
            ////$subjectblognode = $this->subjectblog->find($subjectblogid)->getDescendantsAndSelf()->pluck('id');
            //$blogs  = $this->subjectblog->findOrFail($subjectblogid)->blogs();
            $subjectblog = SubjectBlog::find($subjectblogid);
            $arrsub = $subjectblog->getDescendantsAndSelf()->pluck('id')->flatten()->toArray();
            //dd($arrsub);
            $blogs = Blog::whereHas('subjectblogs',function($q)use($arrsub){
                $q->whereIn('id',$arrsub);
            });
        }
        if ($destinationpointid!='')
        {

            $blogs = $blogs->with('destinationpoint')->whereHas('destinationpoint', function ($q) use ($destinationpointid) {
            $q->whereId($destinationpointid);
            });
        }
        if ($search!='')
        {
            $nsearch = trim(khongdaurw($search),'-');
            $blogs = $blogs->where('slug','like','%'.$search.'%')->orWhere('slug','like','%'.$nsearch.'%');
        }
        $blogs = $blogs->orderBy('created_at','DESC');
        return $blogs->latest()->paginate($n);

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

        return $this->model->count();
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
        $selectdestination = $this->destinationpoint->all()->pluck('title', 'id');
        $selectsubject = $this->subjectblog->getNestedList('title','id','--');
        return compact('selectdestination','selectsubject');
    }
    public function store($inputs,$strimg ,$user)
    {
        if(isset($inputs['subjecttours'])) {
            $subjectblogs = $inputs['subjecttours'];
        } else {
            $subjectblogs = array();
        }
        //create blog object
        $blog = new $this->blog;
        $blog->destinationpoint_id = $inputs['destinationpoint'];
        $blog->title = $inputs['title'];
        $blog->slug = khongdaurw($inputs['title']);
        $blog->description = $inputs['description'];
        $blog->content = $inputs['content'];
        $blog->images = $strimg;
        $blog->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $blog->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $blog->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        $blog->author = $user->id;
        $blog->publish = 1;
        $blog->save();
        // makeing pivot table
        $blog->subjectblogs()->attach($subjectblogs);
    }
    public function store_event($inputs,$strimg ,$user)
    {
        if(isset($inputs['subjecttours'])) {
            $subjectblogs = $inputs['subjecttours'];
        } else {
            $subjectblogs = array();
        }
        //create blog object
        $blog = new $this->blog;
        $blog->destinationpoint_id = $inputs['destinationpoint'];
        $blog->title = $inputs['title'];
        $blog->slug = khongdaurw($inputs['title']);
        $blog->description = $inputs['description'];
        $blog->content = $inputs['content'];
        $blog->images = $strimg;
        $blog->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $blog->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $blog->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        $blog->author = $user->id;
        $blog->publish = 0;
        $blog->save();
        // makeing pivot table
        $blog->subjectblogs()->attach($subjectblogs);
    }
    public function edit($id)
    {
        $blog = $this->blog->findOrFail($id);
        $selectdestination = $this->destinationpoint->all()->pluck('title', 'id');
        $selectsubject = $this->subjectblog->getNestedList('title','id','--');
        $selectedsubjectblogs = $blog->subjectblogs->pluck('id');
        //dd($startdates);
        //dd($selecteddestinationpoints);
        return compact('selectdestination','selectsubject','blog','selectedsubjectblogs');
    }
    public function getBlogById($id){
        return  $this->blog->findOrFail($id);
    }
    public function update_event($inputs, $id , $strimg ,$user)
    {
        //create blog object
        $blog = $this->getBlogById($id);
        $blog->destinationpoint_id = $inputs['destinationpoint'];
        $blog->title = $inputs['title'];
        $blog->slug = khongdaurw($inputs['title']);
        $blog->description = $inputs['description'];
        $blog->content = $inputs['content'];
        $blog->images = $strimg;
        $blog->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $blog->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $blog->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        $blog->author = $user->id;
        $blog->save();
    }
    public function update($inputs, $id , $strimg )
    {
        if(isset($inputs['subjecttours'])) {
            $subjectblogs = $inputs['subjecttours'];
        } else {
            $subjectblogs = array();
        }
        //create blog object
        $blog = $this->getBlogById($id);
        $blog->destinationpoint_id = $inputs['destinationpoint'];
        $blog->title = $inputs['title'];
        $blog->slug = khongdaurw($inputs['title']);
        $blog->description = $inputs['description'];
        $blog->content = $inputs['content'];
        $blog->images = $strimg;
        $blog->publish = $inputs['publish'];
        $blog->seokeyword = $inputs['seokeyword']==''?trim(khongdau($inputs['title'])):$inputs['seokeyword'];
        $blog->seodescription = $inputs['seodescription']==''?strip_tags($inputs['description']):$inputs['seodescription'];
        $blog->seotitle = $inputs['seotitle']==''?trim(khongdau($inputs['title'])):$inputs['seotitle'];
        if(isset($inputs['created_at'])&&$inputs['created_at']!=''){
            //die($inputs['created_at']);
            $blog->created_at = Carbon::createFromFormat('d/m/Y', $inputs['created_at']);
        }
        $blog->save();
        $blog->touch();
        //delete pivot table
        $blog->subjectblogs()->detach();
        // making new pivot table
        $blog->subjectblogs()->attach($subjectblogs);
    }
    public function destroy($id)
    {
        $blog = $this->getBlogById($id);
        $strimages = $blog->images;
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
        //thay doi blog diem den ve mac dinh
        //$blog->comments()->delete();

        $blog->delete();
    }
    public function getSightPointByDestinationPoints($ids){
        return  $this->sightpoint->whereIn('destinationpoint_id',$ids)->get();
    }
}