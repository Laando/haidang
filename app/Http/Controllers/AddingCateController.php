<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AddingCateRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AddingCateRequest;
use App\Http\Requests\AddingCateUpdateRequest;
class AddingCateController extends Controller {

    public function __construct(AddingCateRepository $addingcate_gestion)
    {
        $this->addingcate_gestion = $addingcate_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        // show users with 10 users per page
        $addingcates = $this->addingcate_gestion->index(10);

        $links = str_replace('/?', '?', $addingcates->render());

        return view('back.addingcate.index', compact('addingcates', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('back.addingcate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AddingCateRequest $request)
    {
        $this->addingcate_gestion->store($request->all() );

        return redirect('addingcate')->with('ok', trans('back/addingcates.stored'));
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
        return view('back.addingcate.edit',  $this->addingcate_gestion->edit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(AddingCateUpdateRequest $request,$id)
    {
        $this->addingcate_gestion->update($request->all(), $id );
        return redirect('addingcate')->with('ok', trans('back/addingcates.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->addingcate_gestion->destroy($id);
        return redirect('addingcate')->with('ok', trans('back/addingcates.destroyed'));
    }

}
