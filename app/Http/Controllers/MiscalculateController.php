<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\MiscalculateRepository;
use Illuminate\Http\Request;
class MiscalculateController extends Controller {

    public function __construct(MiscalculateRepository $miscalculate_gestion)
    {
        $this->miscalculate_gestion = $miscalculate_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        // show users with 10 users per page
        $miscalculates = $this->miscalculate_gestion->index(20);

        $links = str_replace('/?', '?', $miscalculates->render());

        return view('back.miscalculate.index', compact('miscalculates', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('back.miscalculate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->miscalculate_gestion->store($request->all() );

        return redirect('miscalculate')->with('ok', 'Tạo mới khoản dự chi thành công');
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

        return view('back.miscalculate.edit',  $this->miscalculate_gestion->edit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $this->miscalculate_gestion->update($request->all(), $id );
        return redirect('miscalculate')->with('ok', 'Cập nhật khoản dự chi thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->miscalculate_gestion->destroy($id);
        return redirect('miscalculate')->with('ok', 'Xóa dự chi thành công');
    }

}
