<?php namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use App\Repositories\DestinationPointRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BlogController extends Controller {

    public function __construct(Request $request )
    {
        $this->request = $request ;
    }
    public function index( $slug = '' , $slugCategory = '' , $search = '' ) {
        $request  = $this->request->all();
        //DB::enableQueryLog();
        $blog =  Blog::where('publish',1);
        if($slug != ''){
            $blog = $blog->with('subjectblogs')->where('slug','like',$slug )->get();
        } else {
            if(isset($request['search']) && $request['search']!=''){
                $search = $request['search'];
            }
            if($slugCategory != ''){
                $blog =  $blog->whereHas('subjectblogs',function($q) use ($slugCategory){
                    $q->where('slug','like', khongdaurw($slugCategory) );
                });
            }
            if($search != ''){
                $blog =  $blog->whereHas('subjectblogs',function($q) use ($search){
                    $q->where('slug','like', '%' .khongdaurw($search). '%' );
                })->orWhere('slug','like', '%' .khongdaurw($search). '%' );
            }
            if(isset($request['begin'])){
                $begin  = filter_var($request['begin'],FILTER_SANITIZE_NUMBER_INT);
                $take = isset($request['take']) ? $request['take'] : 6;
                $take = is_int($take) ? $take : (filter_var($take,FILTER_SANITIZE_NUMBER_INT));
                $blog = $blog->take($take)->skip($begin);
            }
            $blog = $blog->with('subjectblogs')->get(['id','title','slug', 'destinationpoint_id','images','description','author','created_at'])->toArray();
        }
        //dd(DB::getQueryLog());
        return response()->json($blog,200);
    }
    public function getBlogCategory($slug = '' , $search = '') {
        return $this->index('',$slug , $search);
    }
    public function getBlog($slug = '') {
        return $this->index($slug );
    }
}
