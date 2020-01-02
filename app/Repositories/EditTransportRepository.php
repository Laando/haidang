<?php
namespace App\Repositories;


use App\Models\EditTransport;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class EditTransportRepository extends BaseRepository {
    protected $edittransport;
    public function __construct(EditTransport $edittransport)
    {
        $this->edittransport = $edittransport;
    }
    public function index($n)
    {
        return $this->edittransport
            ->latest()
            ->paginate($n);
    }
    public function create()
    {

    }
    public function store($inputs)
    {
        $edittransport = new $this->edittransport;
        $edittransport->title  = $inputs['title'];
        $edittransport->seat = $inputs['seat'];
        $edittransport->price = $inputs['price'];
        $edittransport->day = $inputs['day'];
        $edittransport->type = $inputs['type'];
        if($inputs['multiroute']!='') {
            $edittransport->multiroute_id = $inputs['multiroute'];
        }  else {
            $edittransport->multiroute_id = null;
        }
        if($inputs['sourcepoint']!='') {
            $edittransport->sourcepoint_id = $inputs['sourcepoint'];
        } else {
            $edittransport->sourcepoint_id = null;
        }
        if($inputs['destinationpoint']!='') {
            $edittransport->destinationpoint_id = $inputs['destinationpoint'];
        } else {
            $edittransport->destinationpoint_id = null;
        }
        $edittransport->save();
    }
    public function edit($id)
    {
        $edittransport = $this->edittransport->findOrFail($id);
        return compact('edittransport');
    }
    public function getEditTransportById($id){
        return  $this->edittransport->findOrFail($id);
    }
    public function update($inputs, $id)
    {
        $edittransport = $this->getEditTransportById($id);
        $edittransport->title  = $inputs['title'];
        $edittransport->seat = $inputs['seat'];
        $edittransport->price = $inputs['price'];
        $edittransport->day = $inputs['day'];
        $edittransport->type = $inputs['type'];
        if($inputs['multiroute']!='') {
            $edittransport->multiroute_id = $inputs['multiroute'];
        }  else {
            $edittransport->multiroute_id = null;
        }
        if($inputs['sourcepoint']!='') {
            $edittransport->sourcepoint_id = $inputs['sourcepoint'];
        } else {
            $edittransport->sourcepoint_id = null;
        }
        if($inputs['destinationpoint']!='') {
            $edittransport->destinationpoint_id = $inputs['destinationpoint'];
        } else {
            $edittransport->destinationpoint_id = null;
        }
        $edittransport->save();
    }
    public function destroy($id)
    {
        $edittransport = $this->getEditTransportById($id);
        $edittransport->delete();
    }
    public function all()
    {
        return $this->edittransport->orderBy('priority','asc')->get();
    }

}