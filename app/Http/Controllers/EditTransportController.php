<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DestinationPoint;
use App\Models\MultiRoute;
use App\Models\SourcePoint;
use App\Repositories\EditTransportRepository;
use Illuminate\Http\Request;
use App\Http\Requests\EditTransportRequest;
use App\Http\Requests\EditTransportUpdateRequest;
class EditTransportController extends Controller {

    public function __construct(EditTransportRepository $edittransport_gestion , MultiRoute $multiRoute)
    {
        $this->edittransport_gestion = $edittransport_gestion;
        $this->multiroute_gestion = $multiRoute;
        $this->middleware('admin');
    }
    public function index()
    {
        // show users with 10 users per page
        $edittransports = $this->edittransport_gestion->index(10);

        $links = str_replace('/?', '?', $edittransports->render());

        return view('back.edittransport.index', compact('edittransports', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        ///// lists trước all => arry /// all trước lists => collection
        $select = $this->multiroute_gestionpluck('title', 'id')->all();
        $select = [''=>'Không phải liên tuyến'] + $select;
        $selectsource = SourcePoint::all()pluck('title', 'id')->all();
        $selectdestination = DestinationPoint::all()pluck('title', 'id')->all();
        $selectsource = [''=>'Chọn điểm khởi hành'] + $selectsource;
        $selectdestination = [''=>'Chọn điểm đến'] + $selectdestination;
        return view('back.edittransport.create',compact('select','selectsource','selectdestination'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(EditTransportRequest $request)
    {
        $this->edittransport_gestion->store($request->all() );

        return redirect('edittransport')->with('ok', trans('back/edittransports.stored'));
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
        $select = $this->multiroute_gestionpluck('title', 'id')->all();
        $select = [''=>'Không phải liên tuyến'] + $select;
        $selectsource = SourcePoint::all()pluck('title', 'id')->all();
        $selectdestination = DestinationPoint::all()pluck('title', 'id')->all();
        $selectsource = [''=>'Chọn điểm khởi hành'] + $selectsource;
        $selectdestination = [''=>'Chọn điểm đến'] + $selectdestination;
        return view('back.edittransport.edit',  $this->edittransport_gestion->edit($id),compact('select','selectsource','selectdestination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(EditTransportUpdateRequest $request,$id)
    {
        $this->edittransport_gestion->update($request->all(), $id );
        return redirect('edittransport')->with('ok', trans('back/edittransports.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->edittransport_gestion->destroy($id);
        return redirect('edittransport')->with('ok', trans('back/edittransports.destroyed'));
    }

}
