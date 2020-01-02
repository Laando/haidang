<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\RegionRepository;
use Illuminate\Http\Request;
use App\Http\Requests\RegionRequest;

class RegionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    protected $region_gestion;
	public function __construct(RegionRepository $region_gestion )
	{
        $this->region_gestion = $region_gestion;
        $this->middleware('admin');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
        $regions = $this->region_gestion->all();

        return view('back.regions.region', compact('regions'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RegionRequest $request)
	{
        $this->region_gestion->update($request->except('_token'));

        return redirect('regions')->with('ok', trans('back/regions.ok'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
