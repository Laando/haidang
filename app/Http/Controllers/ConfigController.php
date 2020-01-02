<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ConfigRepository;
use App\Http\Requests\ConfigRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ConfigUpdateRequest;
use Illuminate\Support\Facades\File;
class ConfigController extends Controller {

    public function __construct(ConfigRepository $config_gestion )
    {
        $this->config_gestion = $config_gestion;
        $this->middleware('admin');
    }
	public function index()
	{
        return $this->indexGo('total');
	}
    public function indexSort($type)
    {
        return $this->indexGo($type, true);
    }
    private function indexGo($type, $ajax = false)
    {
        $counts = $this->config_gestion->counts();
        // show users with 10 users per page
        $configs = $this->config_gestion->index(50, $type);
        $links = str_replace('/?', '?', $configs->render());
        //types = $this->config_gestion->config->groupBy('type')->pluck('type');
        $types = $this->config_gestion->makeTypeList();
        if($ajax)
        {
            return response()->json([
                'view' => view('back.config.table', compact('configs', 'links', 'counts','types'))->render(),
                'links' => str_replace('/sort/total', '', $links)
            ]);
        }

        return view('back.config.index', compact('configs', 'links', 'counts','types'));
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('back.config.create', $this->config_gestion->create());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ConfigRequest $request)
	{
        $this->config_gestion->store($request->all());
        return redirect('config')->with('ok', trans('back/configs.stored'));
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
        return view('back.config.edit',  $this->config_gestion->edit($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ConfigUpdateRequest $request ,$id)
	{
        $config = $this->config_gestion->config->findOrFail($id);
        $this->config_gestion->update($request->all(), $id );
        return redirect('config')->with('ok', trans('back/configs.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->config_gestion->destroy($id);

        return redirect('config')->with('ok', trans('back/configs.destroyed'));
	}

}
