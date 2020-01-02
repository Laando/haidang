<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Repositories\ConsultRepository;
use Illuminate\Http\Request;
use App\Http\Requests\ConsultRequest;
use App\Http\Requests\ConsultUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ConsultController extends Controller {

    public function __construct(ConsultRepository $consult_gestion)
    {
        $this->consult_gestion = $consult_gestion;
        $this->middleware('staff');

    }
    public function index(Request $request = null)
    {
        return $this->indexGo($request);
    }
    private function indexGo($request = null)
    {
        //DB::enableQueryLog();
        $consults = $this->consult_gestion->index(20);
        //dd(DB::getQueryLog());
        $links = str_replace('/?', '?', $consults->render());
        return view('back.consult.index', compact('consults', 'links'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ConsultUpdateRequest $request,$id)
    {
        $this->consult_gestion->update($request->all(), $id );
        return redirect('consult')->with('ok', trans('back/consult.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if(Auth::user()->isAdmin()){
            $this->consult_gestion->destroy($id);
            return redirect('consult')->with('ok', trans('back/consult.destroyed'));
        } else {
            return redirect('consult')->with('error', trans('back/consult.errorright'));
        }

    }
    public function check($id)
    {
        $contact = Contact::find($id);
        if($contact->is_check==null || $contact->is_check==0 ){
            $created_at  = $contact->created_at;
            $contact->is_check  = 1 ;
            $contact->timestamps = false;
            $contact->staff_id = auth()->id();
            $contact->setCreatedAt($created_at);
            $contact->save();
            return redirect('consult')->with('ok', trans('back/consult.checked'));
        } else {
            return redirect('consult')->with('ok', trans('back/consult.notchecked'));
        }
    }


}
