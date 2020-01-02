<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DestinationPoint;
use App\Repositories\MultiRouteRepository;
use Illuminate\Http\Request;
use App\Http\Requests\MultiRouteRequest;
use App\Http\Requests\MultiRouteUpdateRequest;
class MultiRouteController extends Controller {

    public function __construct(MultiRouteRepository $multiroute_gestion , DestinationPoint $destinationPoint)
    {
        $this->destinationpoint = $destinationPoint;
        $this->multiroute_gestion = $multiroute_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        // show users with 10 users per page
        $multiroutes = $this->multiroute_gestion->index(10);

        $links = str_replace('/?', '?', $multiroutes->render());

        return view('back.multiroute.index', compact('multiroutes', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $select = $this->destinationpoint->all()pluck('title', 'id');
        return view('back.multiroute.create',compact('select'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(MultiRouteRequest $request)
    {
        $this->multiroute_gestion->store($request->all() );

        return redirect('multiroute')->with('ok', trans('back/multiroutes.stored'));
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
        $select = $this->destinationpoint->all()pluck('title', 'id');
        return view('back.multiroute.edit',  $this->multiroute_gestion->edit($id),compact('select'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(MultiRouteUpdateRequest $request,$id)
    {
        $this->multiroute_gestion->update($request->all(), $id );
        return redirect('multiroute')->with('ok', trans('back/multiroutes.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->multiroute_gestion->destroy($id);
        return redirect('multiroute')->with('ok', trans('back/multiroutes.destroyed'));
    }

}
