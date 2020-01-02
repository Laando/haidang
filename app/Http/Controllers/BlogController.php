<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\BlogRepository;
use App\Repositories\DestinationPointRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Requests\BlogUpdateRequest;
use Auth;
class BlogController extends Controller {

    public function __construct(BlogRepository $blog_gestion ,DestinationPointRepository $destinationpoint_gestion)
    {
        $this->blog_gestion = $blog_gestion;
        $this->destinationpoint_gestion = $destinationpoint_gestion;
        $this->middleware('staff');
    }
    public function index(Request $request = null)
    {

        return $this->indexGo($request);
    }
    private function indexGo($request = null)
    {
        $destinationpointid = null;
        $subjectblogid = null;
        $search = null;
        if($request!=null) {
            $destinationpoint = $request['destinationpoint'];
            $subjectblogid = $request['subjectblog'];
            $search = $request['search'];
        }
        // show users with 10 users per page
        $blogs = $this->blog_gestion->index(20, $destinationpoint,$subjectblogid,$search);
        //page pagigition
        //dd(implode(";",$blogs->first()->subjectblogs->pluck('title')));
        $links = str_replace('/?', '?', $blogs->render());
        //dd($blogs->first()->user);

        $destinationlist = $this->destinationpoint_gestion->all()->pluck('title','id')->all();
        $destinationlist = array('' => 'Chọn điểm đến') + $destinationlist;
        $subjectlist = $this->blog_gestion->subjectblog->getNestedList('title','id','--');
        $subjectlist = array('' => 'Chọn chủ đề') + $subjectlist;
        return view('back.blog.index', compact('blogs', 'subjectlist', 'destinationlist','links'));
    }
    public function create()
    {
        return view('back.blog.create', $this->blog_gestion->create());
    }
    public function store(BlogRequest $request)
    {
        $user = auth()->user();
        $v = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);
        if ($v->fails())
        {
//            /dd($v->errors());
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
        $count = 1;
        $strimg = '';
        while(Input::hasFile('images-'.$count)){
            $file = Input::file('images-'.$count);
            $filename = khongdaurw($request['title']).'-hinh-'.$count.'.'.$file->getClientOriginalExtension();
            $strimg .= $filename . ';';
            //check file exist step
            $file->move('image',$filename);
            //waterMarkImage($filename);
            $count++;
        }
        $this->blog_gestion->store($request->all(),$strimg ,$user);
        return redirect('blog')->with('ok', trans('back/subjectblogs.stored'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('back.blog.edit',  $this->blog_gestion->edit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(BlogUpdateRequest $request , $id)
    {
        $strimages='';
        $blog = $this->blog_gestion->getBlogById($id);
        if(trim($request['title'])!=trim($blog->title)){
            $strimages = $blog->images;
            $arrimages = explode(';',trim($strimages,';'));
            if($strimages!='') {
                $strimages = '';
                $count = 1;
                foreach ($arrimages as $images) {
                    $ext = explode('.', $images);
                    if ($ext[1] != '') {
                        $newfile = khongdaurw($request['title']) . '-hinh-' . $count . '.' . $ext[1];
                        if (File::exists(public_path() . '/image/' . $images)) {
                            File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                        }
                        $strimages .= $newfile . ';';
                    }
                    $count++;
                }
            }
            $blog->images = $strimages;

            $blog->save();
        }
        //upload new images
        $strimg = $blog->images;
        $beginnumber = count(explode(';',$strimg));
        $countt = 1;
        while(Input::hasFile('images-'.$countt)){
            $count = 1;
            $file = Input::file('images-'.$countt);
            if($file->getClientOriginalExtension()!='') {
                $filename = khongdaurw($request['title']) . '-hinh-' . $beginnumber . '.' . $file->getClientOriginalExtension();
                $file->move('image', $filename);
                waterMarkImage($filename);
                if (strpos($strimg, $filename) === false) {
                    $strimg .= $filename . ';';
                }
                $beginnumber++;
                $countt++;
            }
        }
        if($strimg==''){$strimg = $strimages;}
        $this->blog_gestion->update($request->all(), $id , $strimg);
        return redirect('blog')->with('ok', trans('back/blogs.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $blog = $this->blog_gestion->getBlogById($id);
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
        return redirect()->intended('/blog');
    }
    public function getSightPointByDestinationPoint(){
        $inputs = Input::all();
        $arrid = $inputs['destinationpoints'];
        return json_encode($this->blog_gestion->getSightPointByDestinationPoints($arrid)->pluck('title','id')->all());
    }
    public function delImage($id)
    {
        $inputs = Input::all();
        $img = $inputs['img'];
        if(File::exists(public_path().'\image\\'.$img))
        {
            File::delete(public_path().'\image\\'.$img);
        }
        $blog = $this->blog_gestion->getBlogById($id);
        $strimages = $blog->images;
        $strimages = str_replace($img.';','',$strimages);
        $arrimages = explode(';',trim($strimages,';'));
        //dd($blog->images);
        if($strimages!='') {
            $strimages = '';
            $count = 1;
            foreach ($arrimages as $images) {
                $ext = explode('.', $images);
                if ($ext[1] != '') {
                    $newfile = khongdaurw($blog->title) . '-hinh-' . $count . '.' . $ext[1];
                    if (File::exists(public_path() . '/image/' . $images)) {
                        File::move(public_path() . '/image/' . $images, public_path() . '/image/' . $newfile);
                    }
                    $strimages .= $newfile . ';';
                }
                $count++;
            }
        }
        $blog->images = $strimages;
        $blog->save();
        return 'ok';
    }

}
