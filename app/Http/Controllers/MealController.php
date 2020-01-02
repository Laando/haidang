<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DestinationPoint;
use App\Repositories\MealRepository;
use Illuminate\Http\Request;
use App\Http\Requests\MealRequest;
use App\Http\Requests\MealUpdateRequest;
class MealController extends Controller {

    public function __construct(MealRepository $meal_gestion, DestinationPoint $destinationPoint)
    {
        $this->meal_gestion = $meal_gestion;
        $this->destinationpoint = $destinationPoint;
        $this->middleware('admin');
    }
    public function index()
    {
        // show users with 10 users per page
        $meals = $this->meal_gestion->index(10);

        $links = str_replace('/?', '?', $meals->render());

        return view('back.meal.index', compact('meals', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $selectdestination = $this->destinationpoint->all()pluck('title', 'id');
        return view('back.meal.create',compact('selectdestination'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(MealRequest $request)
    {
        $this->meal_gestion->store($request->all() );

        return redirect('meal')->with('ok', trans('back/meals.stored'));
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
        $selectdestination = $this->destinationpoint->all()pluck('title', 'id');
        return view('back.meal.edit',  $this->meal_gestion->edit($id),compact('selectdestination'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(MealUpdateRequest $request,$id)
    {
        $this->meal_gestion->update($request->all(), $id );
        return redirect('meal')->with('ok', trans('back/meals.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->meal_gestion->destroy($id);
        return redirect('meal')->with('ok', trans('back/meals.destroyed'));
    }

}
