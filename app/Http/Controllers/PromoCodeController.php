<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PromoCodeRepository;
use Illuminate\Http\Request;
use App\Http\Requests\PromoCodeRequest;
use App\Http\Requests\PromoCodeUpdateRequest;
class PromoCodeController extends Controller {

    public function __construct(PromoCodeRepository $promocode_gestion)
    {
        $this->promocode_gestion = $promocode_gestion;
        $this->middleware('admin');
    }
    public function index()
    {
        // show users with 10 users per page
        $promocodes = $this->promocode_gestion->index(10);

        $links = str_replace('/?', '?', $promocodes->render());

        return view('back.promocode.index', compact('promocodes', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('back.promocode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->promocode_gestion->store($request->all() );

        return redirect('promocode')->with('ok', trans('back/promocodes.stored'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
//    public function show($id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
//    public function edit($id)
//    {
//        return view('back.promocode.edit',  $this->promocode_gestion->edit($id));
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
//    public function update(PromoCodeUpdateRequest $request,$id)
//    {
//        $this->promocode_gestion->update($request->all(), $id );
//        return redirect('promocode')->with('ok', trans('back/promocodes.updated'));
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->promocode_gestion->destroy($id);
        return redirect('promocode')->with('ok', trans('back/promocodes.destroyed'));
    }

}
