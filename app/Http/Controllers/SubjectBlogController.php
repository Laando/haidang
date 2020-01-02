<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SubjectBlogRepository;
use Illuminate\Http\Request;
use App\Http\Requests\SubjectBlogRequest;
use App\Http\Requests\SubjectBlogUpdateRequest;
class SubjectBlogController extends Controller {

    public function __construct(SubjectBlogRepository $subjectblog_gestion)
    {
        $this->subjectblog_gestion = $subjectblog_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        // show users with 10 users per page
        $subjectblogs = $this->subjectblog_gestion->index(10);

        $links = str_replace('/?', '?', $subjectblogs->render());

        return view('back.subjectblog.index', compact('subjectblogs', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('back.subjectblog.create', $this->subjectblog_gestion->create());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(SubjectBlogRequest $request)
    {
        $this->subjectblog_gestion->store($request->all() );

        return redirect('subjectblog')->with('ok', trans('back/subjectblogs.stored'));
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
        return view('back.subjectblog.edit',  $this->subjectblog_gestion->edit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Requests\SubjectBlogUpdateRequest $request,$id)
    {
        $this->subjectblog_gestion->update($request->all(), $id );
        return redirect('subjectblog')->with('ok', trans('back/subjectblogs.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->subjectblog_gestion->destroy($id);
        return redirect('subjectblog')->with('ok', trans('back/subjectblogs.destroyed'));
    }

}
