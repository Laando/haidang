<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DestinationPoint;
use App\Models\EditHotel;
use App\Models\EditTransport;
use App\Models\Hotel;
use App\Models\MultiRoute;
use App\Models\Room;
use App\Models\SourcePoint;
use App\Repositories\EditTourRepository;
use Illuminate\Http\Request;
use App\Http\Requests\EditTourRequest;
use App\Http\Requests\EditTourUpdateRequest;
use Illuminate\Support\Facades\Input;

class EditTourController extends Controller {

    public function __construct()
    {

    }
    public function index()
    {
        return view('front.design');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('back.EditTour.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(EditTourRequest $request)
    {
        $this->EditTour_gestion->store($request->all() );

        return redirect('EditTour')->with('ok', trans('back/EditTours.stored'));
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
        return view('back.EditTour.edit',  $this->EditTour_gestion->edit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(EditTourUpdateRequest $request,$id)
    {
        $this->EditTour_gestion->update($request->all(), $id );
        return redirect('EditTour')->with('ok', trans('back/EditTours.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->EditTour_gestion->destroy($id);
        return redirect('EditTour')->with('ok', trans('back/EditTours.destroyed'));
    }
    ///// $http service of angularjs is not ajax !?
    public function getSourcePoint(){
            $rearr = array();
            $sourcepoints = SourcePoint::all();
            $destinationpoints = DestinationPoint::all();
            $multiroutes = MultiRoute::all();
            $rearr['sourcepoints'] = $sourcepoints;
            $rearr['destinationpoints'] = $destinationpoints;
            $rearr['multiroutes'] = $multiroutes;
            return response()->json($rearr);
    }
    public function getEditTransport(){
        $inputs = Input::all();
        $type = $inputs['type']=='Tất cả'?'':$inputs['type'];
        if(isset($inputs['transportseat'])) {
            $transportseat = $inputs['transportseat'];
        } else {
            $transportseat = '';
        }
        $spoint = SourcePoint::find($inputs['sid']);
        $dpoint = DestinationPoint::find($inputs['did']);
        $edittransports  = EditTransport::where('sourcepoint_id','=',$spoint->id)->where('destinationpoint_id','=',$dpoint->id);
        if($type!='') $edittransports->where('type','like',$type) ;
        if($transportseat!=''&&$type=='Ô tô') $edittransports->where('seat','=',$transportseat) ;
        $query  = $edittransports->toSql();
        $edittransports = $edittransports->get();
        $edithotels = Hotel::where('destinationpoint_id','=',$dpoint->id)->get();
        $rearr = array();
        $rearr['edittransports'] = $edittransports;
        $rearr['edithotels'] = $edithotels;
        $rearr['query']= $query;
        $rearr['inputs'] = $inputs;
        return response()->json($rearr);
    }
    public function getEditRoom(){
        $inputs = Input::all();
        $rooms = Room::where('hotel_id','=',$inputs['hid'])->get();
        $rearr = array();
        $rearr['rooms'] = $rooms;
        return response()->json($rearr);
    }
    public function getMyapp(){
        return view('front.myapp');
    }
}
